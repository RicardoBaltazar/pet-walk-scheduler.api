<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = ['name', 'address', 'phone', 'photo', 'owner', 'walker', 'user_id'];

    public function scopeGetByUserId($query, $userId)
    {
        return $query
            ->select()
            ->where('user_id', '=', $userId)
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
