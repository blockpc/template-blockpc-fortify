<?php

use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

uses()->group('roles');

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->user = new_user();
});

it('un usuario sin permiso no puede acceder a la tabla de roles', function () {
    // Assertions
    $this->actingAs($this->user)->get(route('roles.table'))->assertForbidden();
});

it('un usuario con permiso puede acceder a la tabla de roles', function () {
    // Arrange
    $this->user->givePermissionTo('roles.index');
    // Assertions
    $this->actingAs($this->user)->get(route('roles.table'))->assertOk();
});

it('puede buscar roles por name, display_name, descripción', function () {
    $user = new_user(role: 'admin');
    $user->givePermissionTo('roles.index');

    Livewire::actingAs($user)
        ->test('system::roles.table')
        ->set('search', 'admin')
        ->assertSee('Administrador');
});
