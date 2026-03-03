<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
    <livewire:alert />
</x-layouts::app.sidebar>
