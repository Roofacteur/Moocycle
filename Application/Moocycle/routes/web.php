<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CowController;


Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');


Route::get('/cows', [CowController::class, 'index'])->name('cows');
Route::get('/cows/edit/{num_tblVache}', [CowController::class, 'edit'])->name('editcows');
Route::get('/cows/delete/{num_tblVache}', [CowController::class, 'destroy'])->name('deletecows');


Route::get('/calendar', function () {
    return view('layouts.calendar');
})->name('calendar');

Route::get('/health', function () {
    return view('layouts.health');
})->name('health');

Route::get('/tips', function () {
    return view('layouts.tips');
})->name('tips');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
