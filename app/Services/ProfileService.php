<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Profile;
use App\Traits\UserDataTrait;

class ProfileService
{
    use UserDataTrait;

    private $profile;

    public function __construct(Profile $profile) {
        $this->profile = $profile;
    }

    public function createProfile($data): string
    {
        $data = $this->getUserDataAutenticated($data);

        $profile = $this->profile->create($data);

        $this->validateProfile($profile);

        return 'profile successfully registered';
    }

    private function validateProfile(Profile $profile)
    {
        if (is_null($profile->id)) {
            throw new CustomException('Failed to create profile');
        }
    }
}
