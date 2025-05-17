<?php

use App\Http\Controllers\API\AppController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\settings\RoleController;
use App\Http\Controllers\API\settings\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('app/initial', [AppController::class, 'initial'])->middleware('auth:sanctum');

Route::post('settings/store', [RoleController::class, 'store'])->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function(){
  Route::post('settings/user/register', 'register')->name('register');
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function(){
   Route::post('login', 'login')->name('login');
});


  Route::post('logout', [AuthController::class, 'logout'])
  ->middleware('auth:sanctum')
  ->name('logout');

Route::controller(UserController::class)->group(function(){
   Route::get('settings/users', 'index')->name('users');
    // Route::post('login', 'login')->name('login');
});
