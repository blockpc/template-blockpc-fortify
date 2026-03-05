<?php

use App\Models\Role;
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

it('se puede eliminar un rol', function () {
    $user = new_user(role: 'admin');
    $user->givePermissionTo('roles.index');
    $role = Role::factory()->create();

    Livewire::actingAs($user)
        ->test('system::roles.table')
        ->call('confirmDelete', $role->id)
        ->assertSet('deleteModalVisible', true)
        ->set('roleName', $role->display_name)
        ->set('password', 'password')
        ->call('destroyRole')
        ->assertSet('deleteModalVisible', false)
        ->assertSee(__('system.roles.delete.success_message'));

    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

it("no se puede eliminar el rol 'sudo'", function () {
    $user = new_user(role: 'admin');
    $user->givePermissionTo('roles.index');

    $sudoRole = Role::query()->firstOrCreate(
        ['name' => 'sudo', 'guard_name' => 'web'],
        ['display_name' => 'Sudo', 'description' => 'System role', 'is_editable' => false],
    );

    Livewire::actingAs($user)
        ->test('system::roles.table')
        ->call('confirmDelete', $sudoRole->id)
        ->assertSet('deleteModalVisible', true)
        ->set('roleName', $sudoRole->display_name)
        ->set('password', 'password')
        ->call('destroyRole')
        ->assertSet('deleteModalVisible', false)
        ->assertSee(__('system.roles.delete.cannot_delete_role'));

    $this->assertDatabaseHas('roles', ['id' => $sudoRole->id, 'name' => 'sudo']);
});
