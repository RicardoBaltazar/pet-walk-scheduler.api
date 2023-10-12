<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserDataTrait
{
    public function getUserDataAutenticated(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['name'] = $user->name;

        return $data;
    }
}
