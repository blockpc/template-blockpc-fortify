<?php

use App\Models\Role;
use Blockpc\App\Rules\AreEqualsRule;
use Blockpc\Traits\PaginationTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use PaginationTrait;

    public bool $deleteModalVisible = false;

    public ?int $roleToDeleteId = null;

    public string $roleNameToDelete = '';

    public string $roleName = '';

    public string $password = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('roles.index'), 403);
    }

    #[Computed()]
    public function roles(): LengthAwarePaginator
    {
        return Role::query()
            ->with('permissions')
            ->visibleToUser()
            ->search($this->search)
            ->paginate($this->paginate);
    }

    public function confirmDelete(int $roleId): void
    {
        $this->roleToDeleteId = $roleId;
        $roleToDelete = Role::query()->find($this->roleToDeleteId);

        if (! $roleToDelete) {
            $this->cancel();
            session()->flash('danger', __('system.roles.delete.no_role_selected'));

            return;
        }

        $this->roleNameToDelete = $roleToDelete->display_name;

        $this->deleteModalVisible = true;
    }

    public function cancel(): void
    {
        $this->reset(['deleteModalVisible', 'roleToDeleteId', 'roleNameToDelete', 'roleName', 'password']);
    }

    public function destroyRole(): void
    {
        $this->validate([
            'roleName' => ['required', new AreEqualsRule($this->roleNameToDelete, __('system.roles.delete.invalid_role_name'))],
            'password' => 'required|current_password',
        ]);

        if (! $this->roleToDeleteId) {
            $this->cancel();
            session()->flash('danger', __('system.roles.delete.no_role_selected'));

            return;
        }

        $roleToDelete = Role::query()->find($this->roleToDeleteId);

        if (! $roleToDelete) {
            $this->cancel();
            session()->flash('danger', __('system.roles.delete.no_role_selected'));

            return;
        }

        if ($roleToDelete->name === 'sudo') {
            session()->flash('danger', __('system.roles.delete.cannot_delete_role'));
            $this->cancel();

            return;
        }

        $roleToDelete->delete();
        $this->cancel();
        session()->flash('success', __('system.roles.delete.success_message'));
    }
};
