<div>
    <flux:modal.trigger name="create-note">
        <flux:button variant="primary" class="w-full">Crear Nota</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-note" class="w-1/2" :closable="false">
        <div class="space-y-3">
            <div>
                <flux:input label="Título" wire:model="title" />
            </div>

            <div>
                <flux:textarea label="Contenido" wire:model="content" />
            </div>

            <div class="flex justify-end gap-2">
                <flux:button variant="subtle" wire:click="cancel">Cancelar</flux:button>
                <flux:button wire:click="create">Guardar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
