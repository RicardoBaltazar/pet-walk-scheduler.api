<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDates extends Model
{
    use HasFactory;

    protected $table = 'available_walker_dates';

    protected $fillable = ['user_id', 'date', 'start_time', 'end_time'];

    public function scopeGetByDateAndWalkerId($query, $date)
    {
        return $query
            ->select()
            ->where('date', '=', $date['date'])
            ->where('start_time', '=', $date['start_time'])
            ->where('end_time', '=', $date['end_time'])
            ->where('user_id', '=', $date['walker_id'])
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
