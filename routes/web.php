<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\MiniSiteController;
use Illuminate\Support\Facades\Auth;

// Redirection de la racine vers le login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('admin.agents.index') : redirect()->route('login');
});

// Routes d'authentification (générées par Breeze)
require __DIR__.'/auth.php';

// Routes admin protégées par authentification
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.agents.index');
    })->name('dashboard');
    
    // Agents
    Route::resource('agents', AgentController::class);
    
    // Annonces et Avis d'un agent
    Route::prefix('agents/{agent}')->group(function () {
        Route::resource('annonces', AnnonceController::class);
        
        Route::get('avis', [AvisController::class, 'index'])->name('avis.index');
        Route::get('avis/create', [AvisController::class, 'create'])->name('avis.create');
        Route::post('avis', [AvisController::class, 'store'])->name('avis.store');
        Route::get('avis/{avis}', [AvisController::class, 'edit'])->name('avis.edit');
        Route::put('avis/{avis}', [AvisController::class, 'update'])->name('avis.update');
        Route::delete('avis/{avis}', [AvisController::class, 'destroy'])->name('avis.destroy');
        Route::post('avis/{avis}/toggle', [AvisController::class, 'toggleValidation'])->name('avis.toggle');
    });
});

// Mini-sites publics (pour le dev)
Route::get('/minisite/{slug}', [MiniSiteController::class, 'index'])->name('minisite.home');
Route::post('/minisite/{slug}/contact', [MiniSiteController::class, 'contact'])->name('minisite.contact');