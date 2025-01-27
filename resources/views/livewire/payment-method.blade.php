<div class="pt-3" x-data="{ button: true, bankTransfer: false, qrCode: false }">
    <h4 class="mb-3 text-dark">Payment Method</h4>
    <p class="text-muted">Please select your payment method</p>
    @if ($paymentGateways)
        <div class="py-3 justify-content-center">
            @if (in_array('PayU', $paymentGateways))
                <div class="form-check" x-on:click="button = true; bankTransfer = false; qrCode = false">
                    <input class="form-check-input" type="radio" name="payment_method" value="payu" id="payu"
                        checked>
                    <label class="form-check-label" for="payu">
                        Credit or Debit Card (India),UPI and Net Bankings
                        <div>
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/visa.svg"
                                alt="visa logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/mastercard.svg"
                                alt="mastercard logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/google-pay.svg"
                                alt="google pay logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/bhim.svg"
                                alt="bhim logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/pay-tm.svg"
                                alt="paytm logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/phone-pe.svg"
                                alt="phonepe logo" width="54" class="mr-2 mt-2">
                        </div>
                    </label>
                </div>
            @endif
            @if (in_array('PayPal', $paymentGateways))
                <div class="form-check" x-on:click="button = true; bankTransfer = false; qrCode = false">
                    <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypal">
                    <label class="form-check-label" for="paypal">
                        PayPal
                        <div>
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/paypal.svg"
                                alt="paypal logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/mastercard.svg"
                                alt="mastercard logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/visa.svg"
                                alt="visa logo" width="54" class="mr-2 mt-2">
                            <img src="https://d11s7fcxy18ubx.cloudfront.net/node/static/2024/2024-56339-g11143a2892a07a/icons/amex.svg"
                                alt="amex logo" width="54" class="mr-2 mt-2">
                        </div>
                    </label>
                </div>
            @endif
            @if (in_array('Stripe', $paymentGateways))
                <div class="form-check" x-on:click="button = true; bankTransfer = false; qrCode = false">
                    <input class="form-check-input" type="radio" name="payment_method" value="stripe" id="stripe">
                    <label class="form-check-label" for="stripe">
                        Stripe
                    </label>
                </div>
            @endif
            @if (in_array('Bank Transfer', $paymentGateways))
                <div class="form-check" x-on:click="button = false; bankTransfer = true; qrCode = false">
                    <input class="form-check-input" type="radio" name="payment_method" value="bank transfer"
                        id="bank_transfer">
                    <label class="form-check-label" for="bank_transfer">
                        Bank Transfer
                    </label>
                </div>
            @endif
            @if (in_array('PhonePe', $paymentGateways))
                <div class="form-check" x-on:click="bankTransfer = false">
                    <input class="form-check-input" type="radio" name="payment_method" value="phonepe" id="phonepe">
                    <label class="form-check-label" for="phonepe">
                        PhonePe
                    </label>
                </div>
            @endif
        </div>
    @endif
    <button class="btn btn-dark" wire:click.prevent="checkAuth" x-on:click="$dispatch('check-address')"
        x-transition.duration.opacity x-show="button">Continue</button>
    <div x-transition.duration.opacity x-show="bankTransfer" class="bank-details-container">
        <h5 class="mb-3">Bank Transfer Details</h5>
        <div class="bank-details">
            <dl class="row">
                <dt class="col-sm-4">Favoring Beneficiary Bank</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->bank_name }}</dd>

                <dt class="col-sm-4">IFSC Code</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->ifsc_code }}</dd>

                <dt class="col-sm-4">Beneficiary Name</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->account_name }}</dd>

                <dt class="col-sm-4">Account Number</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->account_number }}</dd>

                <dt class="col-sm-4">Branch Name</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->branch_name }}</dd>

                <dt class="col-sm-4">Branch Code</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->branch_code }}</dd>

                <dt class="col-sm-4">Address</dt>
                <dd class="col-sm-8">{{ $bankTransferDetails?->address }}</dd>
            </dl>

            <div class="notice-bar my-3">
                <p class="txt-primary"><strong>Note:</strong></p>
                <ul>
                    @if ($bankTransferDetails)
                        @forelse ($bankTransferDetails?->notes as $note)
                            <li>{{ $note['content'] }}</li>
                        @empty
                            <li>No additional notes available.</li>
                        @endforelse
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div x-transition.duration.opacity x-show="qrCode" class="qr-code-container">
        <h5 class="mb-3">PhonePe</h5>
        <div class="text-center">
            <img src="{{ asset(Storage::url($qrCode?->image)) }}" alt="Payment PhonePe" class="img-fluid"
                loading="lazy">
        </div>
    </div>
</div>
