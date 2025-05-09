<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/car-shows', [Admin::class, 'store']);
Route::put('/car-shows/{id}', [Admin::class, 'update']);
Route::delete('/car-shows/{id}', [Admin::class, 'destroy']);
//                 'organizer'         => $request->organizer,
//                 'event_date'        => $request->event_date,
//                 'event_date_start'  => $request->event_date_start,
//                 'event_date_end'    => $request->event_date_end,
//                 'location'          => $request->location,
//                 'description'       => $request->description,
//             ]);

Route::get('/car-shows', [Admin::class, 'index']); // Ensure this returns all car show data
