<?php

use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('/', [MainController::class, 'loginPage'])->name('home');
Route::get('/login', [MainController::class, 'loginPage'])->name('login');
Route::get('/login/{id}', [MainController::class, 'loginSubmit'])->name('login.submit');
Route::get('/logout', [MainController::class, 'logout'])->name('logout');
Route::get('/plans', [MainController::class, 'plans'])->name('plans');

/*
Route::get('/', function () {
    //return view('welcome');
    $users = User::all();
    dd($users);
});
*/
