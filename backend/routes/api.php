<?php

use App\Http\Controllers\API\AppController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\settings\RoleController;
use App\Http\Controllers\API\settings\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('app/initial', [AppController::class, 'initial'])->middleware('auth:sanctum');

// Route::post('settings/store', [RoleController::class, 'store'])->middleware('auth:sanctum');

// Route::controller(UserController::class)->group(function(){
//   Route::post('settings/user/register', 'register')->name('register');
// })->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function(){
   Route::post('login', 'login')->name('login');
   //Route::post('register', 'register')->name('register');
});


Route::post('logout', [AuthController::class, 'logout'])
  ->middleware('auth:sanctum')
  ->name('logout');

Route::controller(UserController::class)->group(function(){

    Route::get('settings/users', 'index')->name('users');
    Route::post('settings/user/register', 'register')->name('register');
    Route::post('settings/user/edit', 'edit')->name('edit');
    Route::post('/settings/user/changeStatus/{id_user}', 'changeStatus')->name('changeStatus');
    Route::post ('settings/user/uniqueUser/{id_user}', 'uniqueUser')->name('uniqueUser');

})->middleware('auth:sanctum');

Route::get('data_static/ubigeo',  [\App\Http\Controllers\Resources\DataStatic::class, 'ubigeo'])->middleware('authentication:sanctum');
