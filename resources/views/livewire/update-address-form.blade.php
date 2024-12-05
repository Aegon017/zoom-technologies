<x-form-section submit="updateAddress">
    <x-slot name="title">
        {{ __('Address Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your address.') }}
    </x-slot>
    @foreach ($addresses as $index => $address)
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <h1>Address {{ $loop->iteration }}</h1>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="address_{{ $index }}" value="{{ __('Address') }}" />
                <x-input id="address_{{ $index }}" type="text" class="mt-1 block w-full" wire:model="address"
                    required autocomplete="address" />
                <x-input-error for="address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="city_{{ $index }}" value="{{ __('City') }}" />
                <x-input id="city_{{ $index }}" type="text" class="mt-1 block w-full" wire:model="city"
                    required autocomplete="city" />
                <x-input-error for="city" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="state_{{ $index }}" value="{{ __('State') }}" />
                <x-input id="state_{{ $index }}" type="text" class="mt-1 block w-full" wire:model="state"
                    required autocomplete="state" />
                <x-input-error for="state" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="zip_code_{{ $index }}" value="{{ __('Zip code') }}" />
                <x-input id="zip_code_{{ $index }}" type="text" class="mt-1 block w-full"
                    wire:model="zip_code" required autocomplete="zip_code" />
                <x-input-error for="zip_code" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="country_{{ $index }}" value="{{ __('Country') }}" />
                <x-input id="country_{{ $index }}" type="text" class="mt-1 block w-full" wire:model="country"
                    required autocomplete="country" />
                <x-input-error for="id" class="mt-2" />
                <x-input type='hidden' value="{{ $address->id }}" wire:model="addressId" />
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-action-message class="me-3" on="updated">
                {{ __('Updated.') }}
            </x-action-message>
            <x-danger-button wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
            <x-button wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-button>
        </x-slot>
    @endforeach
</x-form-section>
