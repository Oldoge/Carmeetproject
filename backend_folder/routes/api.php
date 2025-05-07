<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/car-shows', [Admin::class, 'store']);
Route::put('/car-shows/{id}', [Admin::class, 'update']);
Route::get('/car-shows', [Admin::class, 'index']); // Ensure this returns all car show data
