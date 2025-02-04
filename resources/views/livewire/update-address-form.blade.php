<x-form-section submit="updateAddress">
    <x-slot name="title">
        {{ __('Address Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your address.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="address" value="{{ __('Address') }}" />
            <x-input id="address" type="text" class="mt-1 block w-full" wire:model="faddress"
                autocomplete="address" />
            <x-input-error for="address" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="city" value="{{ __('City') }}" />
            <x-input id="city" type="text" class="mt-1 block w-full" wire:model="city" autocomplete="city" />
            <x-input-error for="city" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="state" value="{{ __('State') }}" />
            <x-input id="state" type="text" class="mt-1 block w-full" wire:model="state" autocomplete="state" />
            <x-input-error for="state" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="zip_code" value="{{ __('Zip code') }}" />
            <x-input id="zip_code" type="text" class="mt-1 block w-full" wire:model="zip_code"
                autocomplete="zip_code" />
            <x-input-error for="zip_code" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="country" value="{{ __('Country') }}" />
            <x-input id="country" type="text" class="mt-1 block w-full" wire:model="country"
                autocomplete="country" />
            <x-input-error for="id" class="mt-2" />
        </div>
    </x-slot>
    <x-slot name="actions">
        <x-action-message class="me-3" on="updated">
            {{ __('Updated.') }}
        </x-action-message>
        <x-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
