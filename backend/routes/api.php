<?php

use App\Http\Controllers\API\AppController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\settings\IncidenceTypesController;
use App\Http\Controllers\API\settings\PlaceController;
use App\Http\Controllers\API\settings\RoleController;
use App\Http\Controllers\API\settings\UserController;
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

Route::controller(PlaceController::class)->group(function(){

    Route::get('settings/places', 'index')->name('places');
    Route::post('settings/place/save', 'save')->name('save');
    // Route::post('settings/user/edit', 'edit')->name('edit');
    // Route::post('/settings/user/changeStatus/{id_user}', 'changeStatus')->name('changeStatus');
    // Route::post ('settings/user/uniqueUser/{id_user}', 'uniqueUser')->name('uniqueUser');

})->middleware('auth:sanctum');

Route::controller(IncidenceTypesController::class)->group(function(){

    Route::get('settings/incidence_types', 'index')->name('incidence_types');
    Route::post('settings/incidence_types/save', 'save')->name('save');
    // Route::post('settings/user/edit', 'edit')->name('edit');
    // Route::post('/settings/user/changeStatus/{id_user}', 'changeStatus')->name('changeStatus');
    // Route::post ('settings/user/uniqueUser/{id_user}', 'uniqueUser')->name('uniqueUser');

})->middleware('auth:sanctum');

Route::controller(RoleController::class)->group(function(){

    Route::get('settings/roles', 'index')->name('roles');
    Route::post('settings/role/save', 'save')->name('save');
    Route::delete('settings/role/{id}', 'destroy')->name('destroy');

})->middleware('auth:sanctum');

Route::get('data_static/ubigeo',  [\App\Http\Controllers\Resources\DataStatic::class, 'ubigeo'])->middleware('authentication:sanctum');
