@props([
    'name',
    'yes' => 'Si',
    'not' => 'No',
    'color' => 'blue',
    'default' => 'gray',
    'disabled' => false,
    'texto' => null
])

<div {{ $attributes->except(['wire:model.live'])->merge(['class' => 'flex text-xs font-semibold']) }} x-data="{toggle: @entangle($attributes->wire('model')->value()).live }">
    <label for="{{$name}}" class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" name="{{$name}}" id="{{$name}}" class="sr-only peer" {{ $attributes->except('class') }} {{$disabled ? 'disabled' : ''}} />
        <div class="w-10 h-5 bg-{{$default}}-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-{{$color}}-300 dark:peer-focus:ring-{{$color}}-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-{{$color}}-600 after:content-[''] after:absolute after:top after:left-0 after:bg-white after:border-{{$color}}-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-{{$color}}-600 peer-checked:bg-{{$color}}-600"></div>
        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap" x-show="toggle" x-cloak>{{__($texto ?? $yes)}}</span>
        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap" x-show="!toggle" x-cloak>{{__($texto ?? $not)}}</span>
    </label>
</div>
