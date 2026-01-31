<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'logo'];

    public function books() {
        return $this->hasMany(Book::class);
    }

    public function user() {
        return $this->hasOne(User::class);
    }
}
