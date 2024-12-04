<div>
    <div class="card mb-4 border-radius-md">
        <div class="card-header py-3 px-5 bg-orange text-white">
            <h5 class="mb-0 text-orange">Select Billing Address</h5>
        </div>
        <div class="card-body px-5 my-3">
            @csrf
            @foreach (auth()->user()->addresses as $address)
                <div class="d-flex justify-content-between mb-5">
                    <div class="form-check">
                        <input wire:model='' class="form-check-input payment-select" type="radio" name="selected_address"
                            id="address_{{ $address->id }}" value="{{ $address->id }}" required checked>
                        <label class="form-check-label" for="address_{{ $address->id }}">
                            {{ $address->address }}, {{ $address->city }},
                            {{ $address->state }},
                            {{ $address->zip_code }}, {{ $address->country }}
                        </label>
                    </div>
                    <div>
                        <a href="" wire:click.prevent='delete({{ $address->id }})'
                            class="text-danger bg-transparent border-0"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            @endforeach
            <button wire:click.prevent="toggleAddressForm" class="continue-btn btn w-100">Add Address</button>
        </div>
    </div>
    @if ($showAddressForm)
        <div class="card mb-4 border-radius-md">
            <div class="card-header py-3 px-5 bg-orange text-white">
                <h5 class="mb-0 text-orange">Add Billing Address</h5>
            </div>
            <div class="card-body px-5 my-3">
                <form wire:submit='save'>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input wire:model='fAddress' type="text" class="form-control billing-fields" id="address"
                            name="address" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="city">City</label>
                            <input wire:model='city' type="text" class="form-control billing-fields" id="city"
                                name="city" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="state">State</label>
                            <input wire:model='state' type="text" class="form-control billing-fields" id="state"
                                name="state" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="zip">Zip Code</label>
                            <input wire:model='zipCode' type="text" class="form-control billing-fields"
                                id="zip" name="zip_code" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input wire:model='country' type="text" class="form-control billing-fields" id="country"
                            name="country" required>
                    </div>
                    <button type="submit" wire:click.prevent='save'
                        class="btn btn-primary btn-block continue-btn continue-btn border-0">Save</button>
                </form>
            </div>
        </div>
    @endif
</div>
