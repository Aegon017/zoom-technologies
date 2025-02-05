<div class="form-group border-top" x-data="{ show: false }" x-on:promo-code-applied.window="show = true;"
    x-on:promo-code-removed.window="show = false;">
    <div class="my-3">
        <h6>Promo code</h6>
        <div x-show="!show">
            <div class="d-flex gap-1 pr-1">
                <input type="text" class="form-control" id="promocode" wire:model="promoCode"
                    placeholder="Enter promo code">
                <input type="hidden" wire:model="productType" value="{{ $productType }}">
                <input type="hidden" wire:model="slug" value="{{ $slug }}">
                <button class="btn btn-primary" wire:click="applyPromoCode">Apply</button>
            </div>
        </div>
        <div x-show="show">
            <div class="d-flex justify-content-between">
                <span>{{ $promoCode }}</span>
                <button class="btn btn-link" wire:click="removePromoCode">Remove</button>
            </div>
        </div>
    </div>
    <div class="border-top pt-3">
        <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>Rs {{ $coursePrice }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Discount</span>
            <span>- Rs {{ $discount ?? 0 }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>CGST</span>
            <span>Rs {{ $cgst }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>SGST</span>
            <span>Rs {{ $sgst }}</span>
        </div>
    </div>
    <div class="d-flex justify-content-between font-weight-bold">
        <span>Total</span>
        <span>Rs {{ $payablePrice }}</span>
    </div>
</div>
