<?php

namespace App\Http\Controllers\Pets;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPetsRequest;
use App\Services\PetOwnerService;
use App\Services\PetsService;
use Exception;
use Illuminate\Support\Facades\Auth;

class RegisterPetsController extends Controller
{
    private $petOwnerService;

    public function __construct(PetOwnerService $petOwnerService)
    {
        $this->petOwnerService = $petOwnerService;
    }

    public function __invoke(RegisterPetsRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $data['user_id'] = $user->id;

        try {
            $response = $this->petOwnerService->registerPet($data);
            return response()->json($response);
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
