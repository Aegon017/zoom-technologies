<div class="pt-3">
    <h6>Select payment method: </h6>
    <form action="{{ route('payment.initiate') }}" method="POST">
        @csrf
        <div class="row pb-3 px-5 justify-content-center">
            <div class="form-check col-md-4 pl-5 payu-input">
                <input class="form-check-input payment-select" type="radio" value="payu" name="payment_method"
                    id="payu" checked>
                <label class="form-check-label" for="payu">
                    <img src="{{ asset('frontend/assets/img/icon/payu-icon.png') }}" alt="payu">
                </label>
            </div>
            <div class="form-check col-md-4 pl-5 paypal-input">
                <input class="form-check-input payment-select" type="radio" value="paypal" name="payment_method"
                    id="paypal">
                <label class="form-check-label" for="paypal">
                    <img src="{{ asset('frontend/assets/img/icon/paypal-icon.png') }}" alt="paypal">
                </label>
            </div>
            <div class="form-check col-md-4 pl-5 stripe-input">
                <input class="form-check-input payment-select" type="radio" value="stripe" name="payment_method"
                    id="stripe">
                <label class="form-check-label" for="stripe">
                    <img src="{{ asset('frontend/assets/img/icon/stripe-icon.png') }}" alt="stripe">
                </label>
            </div>
        </div>
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="payable_price" value="{{ $payablePrice }}">
        <input type="hidden" name="product_type" value="{{ $productType }}">
        <button type="submit" class="btn btn-primary btn-block paynow-btn continue-btn border-0">
            Pay Now
        </button>
    </form>
</div>
