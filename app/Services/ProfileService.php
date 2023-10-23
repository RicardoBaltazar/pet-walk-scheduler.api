<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Profile;
use App\Traits\AuthenticatedUserIdTrait;
use App\Traits\UserDataTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    use UserDataTrait;
    use AuthenticatedUserIdTrait;

    private $profile;

    public function __construct(Profile $profile) {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        $authenticatedUserId = $this->getUserId();

        $cacheKey = 'profile-'.$authenticatedUserId;
        $profile = Cache::get($cacheKey);

        if ($profile === null) {
            Log::info('Cache expired or does not exist');
            $profile = $this->profile->getByUserId($authenticatedUserId);

            if ($profile->isEmpty()) {
                return "No profile found.";
            }

            Cache::put($cacheKey, $profile, 1440);

            Log::info('Updated cache');
            return $profile;

        } else {
            Log::info('profile found in the cache');
        }
        return $profile;
    }

    public function createProfile($data): string
    {
        $data = $this->getUserDataAutenticated($data);

        $profile = $this->profile->create($data);

        $this->validateProfile($profile);

        return 'profile successfully registered';
    }

    public function updateProfile($data): string
    {
        $authenticatedUserId = $this->getUserId();
        Cache::forget('profile-'.$authenticatedUserId);

        $authenticatedUserId = $this->getUserId();
        $profile = $this->profile->updateByUserId($authenticatedUserId, $data);

        if ($profile) {
            return 'Profile successfully updated';
        } else {
            return 'Profile update failed';
        }
    }

    private function validateProfile(Profile $profile)
    {
        if (is_null($profile->id)) {
            throw new CustomException('Failed to create profile');
        }
    }
}
