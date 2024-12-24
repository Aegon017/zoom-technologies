<div class="pt-3">
    <h6>Select payment method: </h6>
    <div class="py-3 justify-content-center">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="PayU" id="payu" checked>
            <label class="form-check-label" for="payu">
                PayU
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="PayPal" id="paypal">
            <label class="form-check-label" for="paypal">
                PayPal
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="Stripe" id="stripe">
            <label class="form-check-label" for="stripe">
                Stripe
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="Bank Transfer"
                id="bank_transfer">
            <label class="form-check-label" for="bank_transfer">
                Bank Transfer
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="QR Code" id="qr_code">
            <label class="form-check-label" for="qr_code">
                QR Code
            </label>
        </div>
    </div>
    <button class="btn btn-dark" x-on:click.prevent="expanded = !expanded">Continue</button>
</div>
