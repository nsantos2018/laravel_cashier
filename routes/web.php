<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    $users = User::all();
    dd($users);
});
