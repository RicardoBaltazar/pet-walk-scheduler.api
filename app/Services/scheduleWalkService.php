<?php

namespace App\Services;

use App\Models\AvailableDates;
use App\Models\User;
use App\Traits\FormatDateTimeTrait;
use Illuminate\Database\Eloquent\Collection;

class scheduleWalkService
{
    use FormatDateTimeTrait;

    private $availableDates;
    private $schedule;
    private $user;

    public function __construct(
        AvailableDates $availableDates,
        User $user
    ) {
        $this->availableDates = $availableDates;
        $this->user = $user;
    }

    public function getAvailableSlots() : array
    {
        $datas = $this->availableDates->all();

        foreach ($datas as &$item) {
            $user = $this->user->findOrFail($item->user_id);
            $item['user_name'] = $user->name;
            $item['user_email'] = $user->email;
        }

        foreach ($datas as &$item) {
            $item["date"] = $this->formatDateTime($item["date"], 'd/m/Y');
            $item["start_time"] = $this->formatDateTime($item["start_time"], 'H:i');
            $item["end_time"] = $this->formatDateTime($item["end_time"], 'H:i');
        }

        return $this->formatResponse($datas);
    }

    public function scheduleWalk($owner, $date, $startTime)
    {
        return 'scheduleWalk';
    }

    private function formatResponse(Collection $data): array
    {
        foreach ($data as &$item) {
            unset($item['id']);
            unset($item['user_id']);
            unset($item['created_at']);
            unset($item['updated_at']);
        }
        return $data->toArray();
    }
}
