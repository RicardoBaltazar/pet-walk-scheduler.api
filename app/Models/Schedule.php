<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = ['owner_id', 'walker_id', 'date', 'pet_id', 'start_time', 'end_time', 'status'];

    public function scopeGetByOwnerId($query, $id)
    {
        return $query
            ->select('id', 'owner_id', 'walker_id', 'date', 'pet_id', 'start_time', 'status')
            ->where('owner_id','=',$id)
            ->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function PET()
    {
        return $this->belongsTo(Pet::class);
    }
}
