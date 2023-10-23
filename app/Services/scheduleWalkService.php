<?php

namespace App\Services;

use App\Models\AvailableDates;
use App\Models\User;
use App\Traits\AuthenticatedUserIdTrait;
use App\Traits\FormatDateTimeTrait;
use App\Traits\UserDataTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class scheduleWalkService
{
    use AuthenticatedUserIdTrait;
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

    /**
     *
     * @return mixed
     */
    public function getAvailableSlots()
    {
        $authenticatedUserId = $this->getUserId();

        $cacheKey = 'walker-avaliable-' . $authenticatedUserId;
        $avaliable = Cache::get($cacheKey);

        if ($avaliable === null) {
            Log::info('Cache expired or does not exist');
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

            Cache::put($cacheKey, $datas, 1440);
            Log::info('Updated cache');

            return $this->formatResponse($datas);
        } else {
            Log::info('available found in the cache');
        }

        return $avaliable;
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
