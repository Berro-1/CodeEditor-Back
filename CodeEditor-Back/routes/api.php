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
Route::prefix('chat')->group(function () {
    Route::post("/createChat", [\App\Http\Controllers\ChatController::class, "createChat"]);
    Route::get("/", [App\Http\Controllers\ChatController::class, "getAllChats"]);
});

Route::prefix('message')->group(function () {
    Route::post("/createMessage/{chat_id}", [\App\Http\Controllers\MessageController::class, "createMessage"]);
    Route::get("/get/{chat_id}", [App\Http\Controllers\MessageController::class, "get"]);
});


Route::prefix('user')->group(function () {
    Route::post("/createUser", [\App\Http\Controllers\UserController::class, "createUser"]);
    Route::get("/{id}", [App\Http\Controllers\UserController::class, "readUser"]);
    Route::get("/", [App\Http\Controllers\UserController::class, "readAllUsers"]);
    
});

Route::prefix('code')->group(function () {
    Route::post("/createCode", [\App\Http\Controllers\CodesubmissionController::class, "createCode"]);
    Route::get("/{id}", [App\Http\Controllers\CodesubmissionController::class, "readCode"]);
    Route::get("/", [App\Http\Controllers\CodesubmissionController::class, "readAllCodes"]);
    // Route::delete("/{id}", [App\Http\Controllers\CodesubmissionController::class, "deleteCode"]);
    
});





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
