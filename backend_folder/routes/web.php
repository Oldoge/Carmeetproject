<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/car-shows', [Admin::class, 'index'])->name('admin.car-shows.index');
    Route::get('/car-shows/create', [Admin::class, 'create'])->name('admin.car-shows.create');
    Route::post('/car-shows', [Admin::class, 'store'])->name('admin.car-shows.store');
    Route::get('/car-shows/{carShow}/edit', [Admin::class, 'edit'])->name('admin.car-shows.edit');
    Route::put('/car-shows/{carShow}', [Admin::class, 'update'])->name('admin.car-shows.update');
    Route::delete('/car-shows/{carShow}', [Admin::class, 'destroy'])->name('admin.car-shows.destroy');
});
