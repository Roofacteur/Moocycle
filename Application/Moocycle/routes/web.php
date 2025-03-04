<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CowController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/home', function () {
    return view('welcome');
})->name('home');
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function() {
    // Route pour afficher toutes les vaches
    Route::get('/cows', [CowController::class, 'get'])->name('cows.get');
    // Route pour filtrer les vaches par race
    Route::get('/cows/filter', [CowController::class, 'filter'])->name('cows.filter');
    // Route pour supprimer une vache
    Route::delete('/cows/{num_tblVache}', [CowController::class, 'destroy'])->name('cows.delete');
    // Route pour soumettre le formulaire pour ajouter une vache
    Route::post('/cows/store', [CowController::class, 'store'])->name('addcows.store');
    // Route pour afficher le formulaire d'ajout de vache
    Route::get('/cows/add', [CowController::class, 'create'])->name('addcows.form');
    // Route pour modifier une vache
    Route::put('/cows/update/{num_tblVache}', [CowController::class, 'update'])->name('cows.update');
    // Route pour afficher une vache
    Route::get('/cows/{num_tblVache}', [CowController::class, 'show'])->name('cows.read');
    // Route pour appeler la page de modification de la vache
    Route::get('/cows/edit/{num_tblVache}', [CowController::class, 'edit'])->name('cows.edit');

    Route::get('/calendar', function () {
        return view('layouts.calendar');
    })->name('calendar');

    Route::get('/calendar', [CowController::class, 'calendar'])->name('calendar');
    // Route pour afficher les vaches et le bouton de chaleur
    Route::get('/health', [CowController::class, 'health'])->name('health');
    Route::post('/health/{num_tblVache}/increment-lactation', [CowController::class, 'incrementLactation'])->name('incrementLactation');
    Route::post('/health/{num_tblVache}/add-latest-date', [CowController::class, 'addLatestDate']);
    Route::get('/tips', function () {
        return view('layouts.tips');
    })->name('tips');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    // Route pour la déconnexion
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


require __DIR__.'/auth.php';
