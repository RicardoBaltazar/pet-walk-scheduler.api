<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Services\ImageUploadService;
use App\Services\ProfileService;

class RegisterProfileController extends Controller
{
    private $profile;
    private $imageUploadService;

    public function __construct(
        ProfileService $profile,
        ImageUploadService $imageUploadService
    ) {
        $this->profile = $profile;
        $this->imageUploadService = $imageUploadService;
    }

    public function __invoke(ProfileRequest $request)
    {
        $imagePath = $this->uploadImage($request);
        $data = $request->all();
        $data['photo'] = $imagePath;

        try {
            $response = $this->profile->createProfile($data);
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    private function uploadImage($request)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            return $this->imageUploadService->upload($request->file('photo'));
        }
    }
}
