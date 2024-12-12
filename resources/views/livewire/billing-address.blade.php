<div>
    <h4 class="mb-3 text-dark">Billing Address</h4>
    <p class="text-muted">Please enter your billing address</p>
    <div class="billing-section">
        <form wire:submit="save">
            <div class="form-group">
                <label for="streetAddress">Street Address *</label>
                <input type="text" class="form-control" id="streetAddress" wire:model='streetAddress'
                    placeholder="Enter street address">
            </div>
            <div class="form-group">
                <label for="city">City *</label>
                <input type="text" class="form-control" id="city" wire:model='city' placeholder="Enter city">
            </div>
            <div class="form-group">
                <label for="state">State *</label>
                <input type="text" class="form-control" id="state" wire:model='state' placeholder="Enter State">
            </div>
            <div class="form-group">
                <label for="country">Country *</label>
                <input type="text" class="form-control" id="country" wire:model='country'
                    placeholder="Enter Country">
            </div>
            <div class="form-group">
                <label for="zipCode">zip code *</label>
                <input type="text" class="form-control" id="zipCode" wire:model='zipCode'
                    placeholder="Enter zip code">
            </div>
            <button type="submit" class="btn-orange">Submit</button>
        </form>
    </div>
</div>
