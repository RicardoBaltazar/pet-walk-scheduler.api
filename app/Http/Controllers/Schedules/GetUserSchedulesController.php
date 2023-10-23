<?php

namespace App\Http\Controllers\Schedules;

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
        return $this->petOwnerService->getUserSchedules();
    }
}
