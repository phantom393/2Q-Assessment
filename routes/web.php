<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/', Login::class);
Route::get('/', Login::class)->name('login');

Route::middleware('auth:admin')->get('/dashboard', function () {
    return view('admin.dashboard');
});