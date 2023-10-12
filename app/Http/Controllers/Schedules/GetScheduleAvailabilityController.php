<?php

namespace App\Http\Controllers\Schedules;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\scheduleWalkService;

class GetScheduleAvailabilityController extends Controller
{
    private $scheduleWalkService;

    public function __construct(scheduleWalkService $scheduleWalkService)
    {
        $this->scheduleWalkService = $scheduleWalkService;
    }

    public function __invoke()
    {
        try {
            $response = $this->scheduleWalkService->getAvailableSlots();
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
