<?php

namespace App\Http\Controllers\Pets;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\PetOwnerService;

class GetUserPetsController extends Controller
{
    private $petOwnerService;

    public function __construct(PetOwnerService $petOwnerService)
    {
        $this->petOwnerService = $petOwnerService;
    }

    public function __invoke()
    {
        try {
            $response = $this->petOwnerService->getPets();
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
