<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = ['owner_id', 'walker_id', 'date', 'pet_id', 'start_time', 'end_time', 'status'];

    public function scopeGetByUserId($query, $id)
    {
        return $query
            ->select('id', 'owner_id', 'walker_id', 'date', 'pet_id', 'start_time', 'status')
            ->where('owner_id','=',$id)
            ->orWhere('walker_id', $id)
            ->get();
    }

    public function scopeUpdateById($query, $data)
    {
        return $query
            ->where('id', $data['id'])
            ->update(['status' => $data['status']]);
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
