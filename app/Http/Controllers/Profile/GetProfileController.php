<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ProfileService;

class GetProfileController extends Controller
{
    private $profile;

    public function __construct(
        ProfileService $profile
    ) {
        $this->profile = $profile;
    }

    public function __invoke()
    {
        try {
            $response = $this->profile->getProfile();
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
