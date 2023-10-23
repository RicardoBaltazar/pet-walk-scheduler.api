<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\AvailableDates;
use App\Models\Profile;
use App\Traits\AuthenticatedUserIdTrait;
use Illuminate\Support\Facades\Cache;

class PetWalkerService
{
    use AuthenticatedUserIdTrait;

    private $availableDates;
    private $profile;

    public function __construct(
        AvailableDates $availableDates,
        Profile $profile
    ) {
        $this->availableDates = $availableDates;
        $this->profile = $profile;
    }

    public function setAvailableSlot(array $data): string
    {
        $authenticatedUserId = $this->getUserId();
        Cache::forget('walker-avaliable-'.$authenticatedUserId);

        $userId = $this->getUserId();
        $userProfile = $this->profile->getByUserId($userId);

        if($userProfile->first()->walker == false){
            throw new CustomException('Only pet walkers can register an available time slot. You can change your status to walker if you wish');
        }

        $data['user_id'] = $userId;

        $this->availableDates->create($data);

        return 'registered availability';
    }
}
