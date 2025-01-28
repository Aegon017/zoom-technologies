<div>
    <div class="form-group border-top">
        <label for="promocode" class="mt-3">Enter a gift card, voucher or promotional
            code</label>
        <div class="d-flex gap-1 pr-1">
            <input type="text" class="form-control" id="promocode" wire:model='promoCode' placeholder="Enter code">
            <button class="btn btn-primary" wire:click="applyPromoCode">Apply</button>
        </div>
    </div>
    <div class="border-top pt-3">
        <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>Rs {{ $coursePrice }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>CGST</span>
            <span>Rs {{ $cgst }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>SGST</span>
            <span>Rs {{ $sgst }}</span>
        </div>
        @if ($discount)
            <div class="d-flex justify-content-between">
                <span>Discount</span>
                <span>Rs {{ $discount }}</span>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between font-weight-bold">
        <span>Total</span>
        <span>Rs {{ $payablePrice }}</span>
    </div>
</div>
