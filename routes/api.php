<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(AppController::class)->group(function() {
        Route::post('Create_User', 'Create_User');
        Route::put('Update_User/{id}','Update_User');
        Route::delete('Delete_User/{id}','Delete_User');
    });
});

