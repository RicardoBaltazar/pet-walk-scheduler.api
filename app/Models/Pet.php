<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $table = 'pets';

    protected $fillable = ['name', 'breed', 'age', 'size', 'user_id'];

    public function scopeGetUserPet($query, $data)
    {
        return $query
            ->select()
            ->where('name', '=', $data['pets']['name'])
            ->where('breed', '=', $data['pets']['breed'])
            ->where('user_id', '=', auth()->user()->id)
            ->first();
    }

    public function scopeGetByUserId($query, $userId)
    {
        return $query
            ->select("id", "name", 'breed', 'age', 'size')
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
