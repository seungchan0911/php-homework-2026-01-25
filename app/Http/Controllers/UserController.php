<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;

class UserController extends Controller
{
    public function mypage() {
        $rentals = Rental::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('user.mypage', compact('rentals'));
    }
}
