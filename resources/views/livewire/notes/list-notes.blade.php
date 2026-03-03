<div>
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">{{ __('Notes') }}</h1>

            {{-- Botón: abrir modal crear (Flux) --}}
            <flux:button variant="primary" color="blue" wire:click="$set('createOpen', true)">{{ __('New Note') }}</flux:button>
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <div class="">
                    <flux:input icon="magnifying-glass" :loading="false" :clearable="true" placeholder="{{ __('Search notes...') }}" wire:model.live.debounce.500ms="search" class="max-w-md w-full" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($this->notes as $note)
                    <flux:card>
                        <flux:heading size="lg">{{ $note->title }}</flux:heading>
                        <flux:text class="mt-2 mb-4">{{ \Illuminate\Support\Str::limit($note->content, 120) }}</flux:text>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:button size="xs" variant="primary" color="green" wire:click="openEdit({{ $note->id }})">{{ __('Edit Note') }}</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="openDelete({{ $note->id }})">{{ __('Delete Note') }}</flux:button>
                        </div>
                    </flux:card>
                @empty
                    <p class="col-span-full text-sm text-neutral-600 dark:text-neutral-400">{{ __('No notes found.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- modal crear --}}
    <flux:modal name="create-note" wire:model="createOpen" title="{{ __('New Note') }}">
        <div class="space-y-3">
            <div>
                <flux:input label="Título" wire:model="title" />
                @error('title') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <flux:textarea label="Contenido" wire:model.defer="content" />
                @error('content') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <flux:button variant="subtle" wire:click="$set('createOpen', false)">{{ __('Cancel') }}</flux:button>
                <flux:button wire:click="create">{{ __('Create Note') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- modal editar --}}
    <flux:modal name="edit-note" wire:model="editOpen" title="{{ __('Edit Note') }}">
        <div class="space-y-3">
            <div>
                <flux:input label="Título" wire:model.defer="title" />
                @error('title') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <flux:textarea label="Contenido" wire:model.defer="content" />
                @error('content') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <flux:button variant="subtle" wire:click="$set('editOpen', false)">{{ __('Cancel') }}</flux:button>
                <flux:button wire:click="update">{{ __('Save changes') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- modal eliminar --}}
    <flux:modal name="delete-note" wire:model="deleteOpen" title="{{ __('Delete Note') }}">
        <div class="space-y-4">
            <p>{{ __('Are you sure you want to delete this note? This action cannot be undone.') }}</p>

            <div class="flex justify-end gap-2">
                <flux:button variant="subtle" wire:click="$set('deleteOpen', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="destroy">{{ __('Delete Note') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
