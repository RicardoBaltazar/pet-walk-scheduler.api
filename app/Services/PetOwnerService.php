<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Jobs\ScheduleJob;
use App\Models\AvailableDates;
use App\Models\Pet;
use App\Models\Profile;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\AuthenticatedUserIdTrait;
use App\Traits\UserDataTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PetOwnerService
{
    use UserDataTrait;
    use AuthenticatedUserIdTrait;

    private $pet;
    private $profile;
    private $user;
    private $availableDates;
    private $schedule;

    public function __construct(
        Pet $pet,
        Profile $profile,
        User $user,
        AvailableDates $availableDates,
        Schedule $schedule
    ) {
        $this->pet = $pet;
        $this->profile = $profile;
        $this->user = $user;
        $this->user = $user;
        $this->availableDates = $availableDates;
        $this->schedule = $schedule;
    }

    /**
     * @return mixed
     */
    public function getUserSchedules()
    {
        $authenticatedUserId = $this->getUserId();
        $cacheKey = 'schedules-' . $authenticatedUserId;
        $schedules = Cache::get($cacheKey);

        Cache::forget('schedules-' . $authenticatedUserId);

        if ($schedules === null) {
            Log::info('Cache expired or does not exist');
            $schedules = $this->schedule->getByUserId($authenticatedUserId);

            foreach ($schedules as $key => $schedule) {
                $pet = $this->pet->find($schedule->pet_id);
                $owner = $this->user->find($schedule->owner_id);

                $schedules[$key]['pet_name'] = $pet['name'];
                $schedules[$key]['owner_name'] = $owner->name;
            }

            if ($schedules->isEmpty()) {
                return ["No schedules found."];
            }

            Cache::put($cacheKey, $schedules, 1440);
            Log::info('Updated cache');
        } else {
            Log::info('Schedules found in the cache');
        }

        return $schedules;
    }

    public function scheduleWalkWithWalker(array $data): string
    {
        $data = $this->getUserDataAutenticated($data);
        $this->validateIsOwner($data['user_id']);
        $data['owner_id'] = $data['user_id'];

        $pet = $this->pet->getUserPet($data);
        $this->validatePetRegistration($pet);
        $data['pet_id'] = $pet['id'];

        $walker = $this->user->getUserByNameAndEmail($data['walker_name'], $data['walker_email']);
        $this->validateWalkerEligibility($walker);

        $data['walker_id'] = $walker['id'];

        $date = $this->availableDates->getByDateAndWalkerId($data);
        $this->validateDateAvailability($date);

        dispatch(new ScheduleJob($data));

        return 'The scheduling request was made. We will send you an email to confirm the appointment schedule';
    }

    public function registerPet($data)
    {
        $userProfile = $this->profile->getByUserId($data['user_id']);

        if (!$userProfile['owner']) {
            throw new CustomException('Only pet owners can register a pet.');
        }

        $pet = $this->pet->create($data);
        $this->validatePet($pet);

        return 'Pet successfully registered';
    }

    public function getPets()
    {
        $userId = $this->getUserId();
        $pets = $this->pet->getByUserId($userId);
        return $pets;
    }

    public function updateWalkerStatus($data)
    {
        $authenticatedUserId = $this->getUserId();
        Cache::forget('schedules-' . $authenticatedUserId);

        $schedule = $this->schedule->updateById($data);

        if ($schedule) {
            return 'scheduling status updated successfully';
        } else {
            return 'scheduling update failed';
        }
    }

    private function validatePet(object $data): void
    {
        if (is_null($data->id)) {
            throw new CustomException('Failed to create profile');
        }
    }

    private function validateWalkerEligibility(object $data): void
    {
        $dataProfile = $this->profile->getByUserId($data['id']);

        if ($dataProfile['walker'] == false) {
            throw new CustomException('The informed walker is not able to receive achedules');
        }
    }

    private function validateDateAvailability(object $date): void
    {
        if ($date == null || $date->count() == 0) {
            throw new CustomException('he selected date is not available.');
        }
    }

    private function validatePetRegistration(object $data): void
    {
        if ($data == null || $data->count() == 0) {
            throw new CustomException('the pet reported is not registered.');
        }
    }

    private function validateIsOwner(Int $id): void
    {
        $profile = $this->profile->getByUserId($id);

        if ($profile['owner'] == false) {
            throw new CustomException('Only owners can schedule a walk.');
        }
    }
}
