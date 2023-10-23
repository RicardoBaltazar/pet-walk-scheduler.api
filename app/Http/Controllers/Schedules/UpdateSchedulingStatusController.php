<?php

namespace App\Http\Controllers\Schedules;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSchedulingStatusRequest;
use App\Services\PetOwnerService;
use Illuminate\Http\Request;

class UpdateSchedulingStatusController extends Controller
{
    private $petOwnerService;

    public function __construct(PetOwnerService $petOwnerService)
    {
        $this->petOwnerService = $petOwnerService;
    }

    public function __invoke(UpdateSchedulingStatusRequest $request)
    {
        $data = $request->all();

        try {
            $response = $this->petOwnerService->updateWalkerStatus($data);
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
