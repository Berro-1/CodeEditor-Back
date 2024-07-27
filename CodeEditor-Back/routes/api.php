<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
