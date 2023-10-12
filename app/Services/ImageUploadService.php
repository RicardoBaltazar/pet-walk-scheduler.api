<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    public function upload(UploadedFile $image): string
    {
        $imagePath = $image->store('photos', 'public');
        return $imagePath;
    }
}
