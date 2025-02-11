<div class="form-group" x-data="{ show: false }" x-on:promo-code-applied.window="show = true;"
    x-on:promo-code-removed.window="show = false;">
    @guest
        <form action="{{ route('checkout.course') }}">
            <input type="hidden" name="thumbnail" value="{{ $thumbnail }}">
            <input type="hidden" name="thumbnail_alt" value="{{ $thumbnail_alt }}">
            <input type="hidden" name="payable_price" value="{{ $payablePrice }}">
            <input type="hidden" name="product_type" value="{{ $productType }}">
            <input type="hidden" name="name" value="{{ $slug }}">
            <input type="hidden" name="actualName" value="{{ $actualName }}">
            <input type="hidden" name="coursePrice" value="{{ $coursePrice }}">
            <input type="hidden" name="cgst" value="{{ $cgst }}">
            <input type="hidden" name="sgst" value="{{ $sgst }}">
            <input type="hidden" name="payablePrice" value="{{ $payablePrice }}">
            <button class="login-btn text-muted my-3"><span>Have Promo code? click here to apply<span></button>
        </form>
    @endguest
    @auth
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
    @endauth
    <div class="border-top pt-3">
        <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>Rs {{ $coursePrice }}</span>
        </div>
        @if ($discount != 0)
            <div class="d-flex justify-content-between">
                <span>Discount</span>
                <span>Rs {{ $discount ?? 0 }}</span>
            </div>
        @endif
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
