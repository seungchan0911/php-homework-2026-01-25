<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'role',
        'store_id',
    ];

    protected function casts() {
        return ['password' => 'hashed'];
    }

    public function rentals() {
        return $this->hasMany(Rental::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }
}
