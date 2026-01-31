<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['store_id', 'name', 'image', 'quantity'];

    public function store() {
        return $this->belongTo(Store::class);
    }
}
