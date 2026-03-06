@props([
    'name',
    'title',
    'options',
    'empty_values' => 'Sin registros encontrados',
    'selected_ids' => [],
    'search_by' => 'Buscar...'
])

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col text-xs font-semibold']) }}>
    <div class="w-full relative" x-data="{open:false}" x-on:click.away="open=false" role="combobox" :aria-expanded="open">
        <div class="flex space-x-2">
            <button type="button" aria-haspopup="listbox" :aria-expanded="open" class="inline-flex items-center px-2 py-1 text-xs whitespace-nowrap font-semibold uppercase btn-select justify-between w-full bg-transparent border rounded border-gray-500 p-2 h-8" x-on:click="open=!open">
                <span class="float-left">{{ __($title) }}</span>
                <div class="" :class="open ? 'rotate-180' : ''">
                    <flux:icon.chevron-down class="size-4" />
                </div>
            </button>
        </div>
        <div class="absolute z-10 w-full rounded-b shadow-md bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-100 border-l border-r border-b border-zinc-500" x-show="open" x-cloak>
            <ul role="listbox" class="list-reset p-2 max-h-40 text-sm scrollbar-thin scrollbar-thumb-zinc-400 scrollbar-track-zinc-300 overflow-y-auto">
                <li class="sticky top-0 bg-zinc-100 dark:bg-zinc-700">
                    <flux:input icon="magnifying-glass" :loading="false" :clearable="true" placeholder="{{ $search_by }}" wire:model.live.debounce.500ms="{{ $attributes->get('search') }}" />
                </li>
                @forelse ($options as $option_id => $option_name)
                <li @class([
                    'bg-zinc-300 dark:bg-zinc-800/50' => in_array($option_id, $selected_ids)
                ]) wire:click="{{ $attributes->get('click') }}({{ $option_id }})" x-on:click="open=false" id="etiqueta-{{$option_id}}">
                    <div class="p-2 w-full hover:bg-zinc-300 hover:dark:bg-zinc-600 flex justify-between cursor-pointer text-xs">
                        <span>{{ $option_name }}</span>
                        @if ( in_array($option_id, $selected_ids) )
                        <flux:icon.check class="w-4 h-4" />
                        @endif
                    </div>
                </li>
                @empty
                <li class="" x-on:click="open=false" wire:click="$set('{{ $attributes->get('search') }}', null)">
                    <p class="p-2 block dark:text-red-400 text-red-800 hover:bg-red-200 cursor-pointer">{{ $empty_values }}</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
