<div class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('system.roles.title') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('system.roles.subtitle') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:heading class="sr-only">{{ __('system.roles.title') }}</flux:heading>

    <div class="flex flex-col space-y-2">
        @if ( session()->has('success') )
            <flux:callout variant="success">
                {{ session()->get('success') }}
            </flux:callout>
        @endif
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <flux:input icon="magnifying-glass" :loading="false" :clearable="true" placeholder="{{ __('system.roles.search-roles') }}" wire:model.live.debounce.500ms="search" class="max-w-64" />
            </div>
            <div class="flex items-center space-x-2">
                <flux:button variant="primary" color="blue" size="sm" href="{{ route('roles.create') }}">{{ __('system.roles.buttons.create') }}</flux:button>
            </div>
        </div>
        <x-tables.table>
            <x-slot name="thead">
                <tr class="tr">
                    <th scope="col" class="td">{{ __('system.roles.table.name') }}</th>
                    <th scope="col" class="td">{{ __('system.roles.table.description') }}</th>
                    <th scope="col" class="td" align="end">{{ __('system.roles.table.actions') }}</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($this->roles as $role)
                    <tr class="tr tr-hover">
                        <td class="td">
                            <div class="flex flex-col gap-1">
                                <span class="text-base">{{ $role->display_name }}</span>
                                <span class="text-xs italic">{{ $role->name }}</span>
                            </div>
                        </td>
                        <td class="td">
                            <span class="text-xs italic">{{ $role->description }}</span>
                        </td>
                        <td class="td text-right">
                            {{-- <flux:button variant="primary" color="green" size="sm" href="{{ route('roles.edit') }}">{{ __('system.roles.buttons.edit') }}</flux:button> --}}
                        </td>
                    </tr>
                @empty
                    <tr class="tr">
                        <td class="td text-center" colspan="3">
                            {{ __('system.roles.table.no_roles') }}
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-tables.table>

        <flux:pagination :paginator="$this->roles" />
    </div>
</div>
