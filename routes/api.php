<?php

use App\Http\Controllers\KafkaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('send',[KafkaController::class, 'send']);
Route::get('test_send',[KafkaController::class, 'test_send']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
