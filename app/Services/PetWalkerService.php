<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\AvailableDates;
use App\Models\Profile;
use App\Traits\AuthenticatedUserIdTrait;

class PetWalkerService
{
    use AuthenticatedUserIdTrait;

    private $availableDates;
    private $profile;

    public function __construct(
        AvailableDates $availableDates,
        Profile $profile
    ) {
        $this->availableDates = $availableDates;
        $this->profile = $profile;
    }

    public function setAvailableSlot(array $data): string
    {
        $userId = $this->getUserId();
        $userProfile = $this->profile->getByUserId($userId);

        if($userProfile->walker == false){
            throw new CustomException('Only pet walkers can register an available time slot. You can change your status to walker if you wish');
        }

        $data['user_id'] = $userId;

        $this->availableDates->create($data);

        return 'registered availability';
    }

    public function updateWalkerStatus() //Como este método se repete para donos e passeadores, pode ser criado uma classe única. Precisa ser classe pois possuirá atributos
    {
        // atualizar status do pásseio

        //só o passeador agendado pode realizar a alteração do status
    }
}
