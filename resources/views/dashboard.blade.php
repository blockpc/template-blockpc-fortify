<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-2">
                <div class="flex flex-col space-y-2">
                    <div>Mostrar Ejemplos de Alertas</div>
                    <flux:button variant="primary" size="sm" color="red" onclick="Livewire.dispatchTo('alert', 'show', { message: 'Ha ocurrido un error.', alert: 'error', title: 'Error' })">
                            Alerta de Error
                    </flux:button>
                    <flux:button variant="primary" size="sm" color="green" onclick="Livewire.dispatchTo('alert', 'show', { message: 'Operación realizada con éxito.', alert: 'success', title: 'Éxito' })">
                            Alerta de Éxito
                    </flux:button>
                    <flux:button variant="primary" size="sm" color="yellow" onclick="Livewire.dispatchTo('alert', 'show', { message: 'Este es un mensaje de advertencia.', alert: 'warning', title: 'Advertencia' })">
                            Alerta de Advertencia
                    </flux:button>
                    <flux:button variant="primary" size="sm" color="blue" onclick="Livewire.dispatchTo('alert', 'show', { message: 'Información importante para el usuario.', alert: 'info', title: 'Información' })">
                            Alerta de Información
                    </flux:button>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-2">
                <div class="flex flex-col space-y-2">
                    <div>Modal para crear un nota</div>
                    <livewire:notes.create-dashboard-note />
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-2">
                {{-- TODO: Replace with Livewire notification bar component --}}
                Mostrar Barra de Notificaciones de Usuario
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>
