<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatDateTimeTrait
{
    private function formatDateTime(string $dateTime, string $format): string
    {
        return Carbon::parse($dateTime)->format($format);
    }
}
