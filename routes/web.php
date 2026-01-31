<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdministratorController;
use App\Http\Controllers\StoreAdministratorController;

Route::get('/', function() {
    if (auth()->check()) {
        $role = auth()->user()->role;
        
        if ($role == 2) return redirect()->route('super_admin.index');
        if ($role == 1) return redirect()->route('store_admin.index');
        if ($role == 0) return redirect()->route('stores.index');
    }

    return view('auth.register');
});

Route::view('login', 'auth.login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('stores', StoreController::class);
Route::resource('books', BookController::class);
Route::post('books/{book}/rent', [BookController::class, 'rent'])->name('rent');
Route::post('rentals/{rental}/return', [BookController::class, 'return'])->name('return');
Route::get('mypage', [UserController::class, 'mypage'])->name('mypage');

Route::get('super_admin', [SuperAdministratorController::class, 'index'])->name('super_admin.index');
Route::get('super_admin/users', [SuperAdministratorController::class, 'users'])->name('super_admin.users');
Route::get('super_admin/register', [SuperAdministratorController::class, 'showRegister'])->name('super_admin.register');
Route::post('super_admin/register', [SuperAdministratorController::class, 'register'])->name('super_admin.register');

Route::get('store_admin', [StoreAdministratorController::class, 'index'])->name('store_admin.index');
Route::get('store_admin/table_view', [StoreAdministratorController::class, 'tableView'])->name('store_admin.rentals.table_view');
Route::get('store_admin/calendar', [StoreAdministratorController::class, 'calendar'])->name('store_admin.rentals.calendar');
Route::get('store_admin/{user}/profile', [StoreAdministratorController::class, 'userProfile'])->name('store_admin.users.profile');