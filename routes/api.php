<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ApiTokenController;
use App\Http\Controllers\Profile\PasswordController;
use App\Http\Controllers\Event\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:api')->group(function(){
    Route::post('/changepassword',[PasswordController::class,'ChangePassword']);

    Route::post('/CreateEvent',[EventController::class,'CreateEvent']);
    Route::post('/UpdateEvent',[EventController::class,'update']);
    Route::get('/EventDetails',[EventController::class,'Detail']);

    Route::post('/logout',[AuthenticationController::class,'logout']);
});

Route::post('/register',[AuthenticationController::class,'register']);

Route::post('/login',[AuthenticationController::class,'login']);



Route::get('/login',function(){
    dd("Please Login First");
})->name('login');

Route::get('/resetpassword',[PasswordController::class,'ResetPassword']);

