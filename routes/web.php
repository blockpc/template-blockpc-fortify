<?php

use App\Livewire\Notes\ListNotes;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/settings.php';

Route::prefix('sistema')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::get('lista-de-notas', ListNotes::class)->name('notes.index');

        Route::prefix('permisos')->group(function () {
            Route::livewire('/lista-de-permisos', 'system::permission.table')->name('permissions.table');
        });

        Route::prefix('roles')->group(function () {
            Route::livewire('/lista-de-roles', 'system::roles.table')->name('roles.table');
            Route::livewire('/nuevo-rol', 'system::roles.create')->name('roles.create');
        });
    });
