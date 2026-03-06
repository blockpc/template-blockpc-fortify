<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Role;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait Select2RolesTrait
{
    public array $selectedRolesIds = [];

    public string $searchRole = '';

    #[Computed()]
    public function roles(): Collection
    {
        return Role::query()
            ->visibleToUser()
            ->search($this->searchRole)
            ->pluck('display_name', 'id');
    }

    public function selectRole($roleId): void
    {
        if (in_array($roleId, $this->selectedRolesIds)) {
            $this->selectedRolesIds = array_diff($this->selectedRolesIds, [$roleId]);
        } else {
            $this->selectedRolesIds[] = $roleId;
        }
    }
}
