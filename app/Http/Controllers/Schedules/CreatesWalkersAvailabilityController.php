<?php

namespace App\Http\Controllers\Schedules;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailabilityRequest;
use App\Services\PetWalkerService;
use Illuminate\Http\Request;

class CreatesWalkersAvailabilityController extends Controller
{
    private $petWalkerService;

    public function __construct(PetWalkerService $petWalkerService)
    {
        $this->petWalkerService = $petWalkerService;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(AvailabilityRequest $request)
    {
        $data = $request->all();

        try {
            $response = $this->petWalkerService->setAvailableSlot($data);
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
