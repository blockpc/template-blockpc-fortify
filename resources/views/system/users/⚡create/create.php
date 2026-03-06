<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\Select2RolesTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Crear nuevo usuario')] class extends Component
{
    use Select2RolesTrait;

    public string $name = '';

    public string $email = '';

    public bool $auto_password = false;

    public string $password = '';

    public string $password_confirmation = '';

    public array $selectedPermissions = [];

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('users.create'), 403);
    }

    #[Computed()]
    public function permissions(): Collection
    {
        return Permission::query()
            ->visibleToUser()
            ->pluck('display_name', 'id');
    }

    public function save(): mixed
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'auto_password' => 'boolean',
            'password' => $this->auto_password
                ? 'nullable'
                : 'required|string|min:8|confirmed',
        ]);

        if ($this->auto_password) {
            $this->password = Str::random(12);
        }

        DB::transaction(function () {
            $user = User::query()->create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            if (! empty($this->selectedRolesIds)) {
                $roles = Role::query()
                    ->visibleToUser()
                    ->whereIn('id', $this->selectedRolesIds)
                    ->get();
                $user->assignRole($roles);
            }

            if (! empty($this->selectedPermissions)) {
                $permissions = Permission::query()
                    ->visibleToUser()
                    ->whereIn('name', $this->selectedPermissions)
                    ->get();
                $user->givePermissionTo($permissions);
            }
        });

        session()->flash('success', __('system.users.create.success_message'));

        return redirect()->route('users.table');
    }
};
