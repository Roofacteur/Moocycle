<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CowController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route pour afficher toutes les vaches
Route::get('/cows', [CowController::class, 'get'])->name('cows.get');
// Route pour filtrer les vaches par race
Route::get('/cows/filter', [CowController::class, 'filter'])->name('cows.filter');


Route::delete('/cows/{num_tblVache}', [CowController::class, 'destroy'])->name('deletecows'); // Pour supprimer une vache
Route::post('/cows/store', [CowController::class, 'store'])->name('addcows.store'); // Pour soumettre le formulaire
Route::get('/cows/add', [CowController::class, 'create'])->name('addcows.form'); // Pour afficher le formulaire
Route::put('/cows/update/{num_tblVache}', [CowController::class, 'update'])->name('updatecows'); //Pour modifier une vache
Route::get('/cows/edit/{num_tblVache}', [CowController::class, 'edit'])->name('editcows'); //Pour appeler la page de modification de la vache


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
