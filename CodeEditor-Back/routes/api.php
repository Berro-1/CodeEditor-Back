<?php

use App\Http\Controllers\CodesubmissionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group([
    // "middleware" => "authenticate",
    "prefix" => "users",
    "controller" => UserController::class
], function () {
    Route::get('/', [UserController::class, 'readAllUsers']);    
    Route::get('/{id}',  'readUser');
    Route::post('/', 'createUser');
    Route::delete('/{id}',  'deleteUser');
    Route::put('/{id}',  'updateUser');
    // Route::get('/menus/{id}', 'restaurantMenus');
});



Route::group([
    // "middleware" => "authenticate",
    "prefix" => "code",
    "controller" => CodesubmissionController::class
], function () {
    Route::get('/', [CodesubmissionController::class, 'readAllCodes']);    
    Route::get('/{id}',  'readCode');
    // Route::post('/', 'createUser');
    // Route::delete('/{id}',  'deleteUser');
    // Route::put('/{id}',  'updateUser');
    // Route::get('/menus/{id}', 'restaurantMenus');
});






// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
