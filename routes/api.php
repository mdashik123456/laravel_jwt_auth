<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

ROute::group(['middleware' => 'api'], function (){
    Route::post('/reg', [UserController::class,'reg']);
    Route::post('/login', [UserController::class,'login']);
    Route::get('/logout', [UserController::class,'logout']);
    Route::get('/profile', [UserController::class,'showCurrentLoggedInUser']);
});
