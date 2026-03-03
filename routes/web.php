<?php

use App\Livewire\Notes\ListNotes;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';

Route::get('lista-de-notas', ListNotes::class)
    ->middleware(['auth', 'verified'])
    ->name('notes.index');
