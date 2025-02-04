<div>
    <h4 class="mb-3 text-dark">Billing Address</h4>
    <p class="text-muted">Please enter your billing address</p>
    <div class="billing-section">
        <form wire:submit="save">
            <div class="form-group">
                <label for="streetAddress">Street Address (Optional)</label>
                <input type="text" class="form-control" id="streetAddress" wire:model='streetAddress'
                    placeholder="Enter street address">
            </div>
            <div class="form-group">
                <label for="city">City (Optional)</label>
                <input type="text" class="form-control" id="city" wire:model='city' placeholder="Enter city">
            </div>
            <div class="form-group">
                <label for="state">State (Optional)</label>
                <input type="text" class="form-control" id="state" wire:model='state' placeholder="Enter State">
            </div>
            <div class="form-group">
                <label for="country">Country (Optional)</label>
                <input type="text" class="form-control" id="country" wire:model='country'
                    placeholder="Enter Country">
            </div>
            <div class="form-group">
                <label for="zipCode">zip code (Optional)</label>
                <input type="text" class="form-control" id="zipCode" wire:model='zipCode'
                    placeholder="Enter zip code">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">Save Address</button>
                <button class="btn btn-orange" x-on:click.prevent="$refs.checkoutForm.submit()">Continue to pay</button>
            </div>
        </form>
    </div>
</div>
