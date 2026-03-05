<?php

use App\Models\Role;
use Blockpc\Traits\PaginationTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use PaginationTrait;

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
};
