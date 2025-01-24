<?php
use App\Http\Controllers\PersonController;

Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/create', [PersonController::class, 'create'])->middleware('auth')->name('people.create');
Route::post('/people', [PersonController::class, 'store'])->middleware('auth')->name('people.store');
Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');

