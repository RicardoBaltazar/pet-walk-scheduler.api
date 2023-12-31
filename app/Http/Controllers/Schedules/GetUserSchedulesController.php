<?php

namespace App\Http\Controllers\Schedules;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\PetOwnerService;
use Illuminate\Http\Request;

class GetUserSchedulesController extends Controller
{
    private $petOwnerService;

    public function __construct(PetOwnerService $petOwnerService)
    {
        $this->petOwnerService = $petOwnerService;
    }

    public function __invoke()
    {
        try {
            $response = $this->petOwnerService->getUserSchedules();
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
