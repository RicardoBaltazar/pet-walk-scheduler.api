<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Pets\GetUserPetsController;
use App\Http\Controllers\Pets\RegisterPetsController;
use App\Http\Controllers\Profile\GetProfileController;
use App\Http\Controllers\Profile\RegisterProfileController;
use App\Http\Controllers\Profile\UpdateProfileController;
use App\Http\Controllers\Schedules\CreateSchedulesController;
use App\Http\Controllers\Schedules\CreatesWalkersAvailabilityController;
use App\Http\Controllers\Schedules\GetScheduleAvailabilityController;
use App\Http\Controllers\Schedules\GetUserSchedulesController;
use App\Http\Controllers\Schedules\UpdateSchedulingStatusController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', LogoutController::class);

    Route::get('profile', GetProfileController::class);
    Route::post('register/profile', RegisterProfileController::class);
    Route::post('update/profile', UpdateProfileController::class);

    Route::post('register/pets', RegisterPetsController::class);
    Route::get('user/pets', GetUserPetsController::class);

    Route::post('walkers/availability', CreatesWalkersAvailabilityController::class);
    Route::get('schedule/availability', GetScheduleAvailabilityController::class);

    Route::post('schedules', CreateSchedulesController::class);
    Route::get('user/schedules', GetUserSchedulesController::class);
    Route::post('update/scheduling/status', UpdateSchedulingStatusController::class);
});
