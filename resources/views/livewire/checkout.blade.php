<x-frontend-layout>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .custom-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 1rem;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .step-badge {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .checkout-section {
            background-color: white;
            border-radius: 0.5rem;
            padding: 2rem;
        }

        .text-underline {
            text-decoration: underline;
        }

        .loader {
            width: 1rem;
            height: 1rem;
            border: 2px solid #FFF;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
            margin-bottom: -2px;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .login-btn {
            border: none;
            background: transparent;
            margin-left: -6px;
        }

        .login-btn span {
            color: #fd5222;
        }

        .login-btn span:hover {
            color: #cc3309;
            text-decoration: underline;
        }

        .step-badge.active {
            background-color: #fd5222 !important;
            color: white !important;
            font-weight: bold !important;
        }

        .step-item.active {
            font-weight: bold !important;
        }

        .form-check {
            margin-bottom: 1rem;
        }

        .form-check-input {
            accent-color: #fd5222;
            width: 1rem;
            aspect-ratio: 1;
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
            margin-left: 0.5rem;
            font-weight: 500;
        }

        .form-check-label:hover {
            color: #fd5222;
        }

        .otp-input input {
            width: 50px;
            height: 50px;
            margin: 0 8px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid #6f6f6f;
            border-radius: 12px;
            background-color: #eeeeee;
            color: #1d1d1d;
            transition: all 0.3s ease;
        }

        .otp-input input:focus {
            border-color: #fd5222;
            box-shadow: 0 0 0 1px #fd5222;
            outline: none;
        }

        .otp-input input::-webkit-outer-spin-button,
        .otp-input input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input input[type=number] {
            -moz-appearance: textfield;
        }

        #timer {
            font-size: 1rem;
            color: #fd5222;
            font-weight: 500;
            margin-left: 10px;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .expired {
            animation: pulse 2s infinite;
            color: #cc3309;
        }

        .resend-text {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: gray;
        }

        .resend-link {
            color: #fd5222;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: #cc3309;
            text-decoration: underline;
        }

        #email {
            color: #fd5222;
            font-weight: 500;
        }

        .btn-orange {
            color: #fff;
            background-color: #fd5222;
            border-color: #fd5222;
        }

        .btn-orange:focus {
            box-shadow: 0 0 0 .2rem rgba(52, 58, 64, .5);
        }

        .btn-orange:hover {
            color: #fff;
            background-color: #cc3309;
            border-color: #cc3309;
        }

        .gap-1 {
            gap: 1rem;
        }
    </style>
    @php
        $request = request();
        $requestData = $request->all();
        $course_schedule_values = array_filter(
            $requestData,
            function ($key) {
                return strpos($key, 'course_schedule') !== false;
            },
            ARRAY_FILTER_USE_KEY,
        );
    @endphp

    <body x-data="{ activeTab: 1 }">
        <div class="container-fluid bg-white shadow-sm py-3 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <a href="#" class="h2 font-weight-bold text-dark">Checkout</a>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="step-indicator">
                            <div class="step-item" id="step-1">
                                <div class="step-badge bg-light text-muted" data-step="1">1</div>
                                <span class="text-muted">Payment</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" id="step-2">
                                <div class="step-badge bg-light text-muted" data-step="2">2</div>
                                <span class="font-weight-semibold">Sign In / Sign Up</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" id="step-3">
                                <div class="step-badge bg-light text-muted" data-step="3">3</div>
                                <span class="font-weight-semibold">Billing Address</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-3">
            <div class="row">
                <div class="col-12 col-lg-6 pr-lg-4">
                    <div class="checkout-section custom-shadow">
                        <h4 class="mb-3 text-dark">Order Summary</h4>
                        <p class="text-muted">Check your items. And select a suitable shipping method.</p>
                        <div class="product-card card overflow-hidden border-0">
                            <div class="card-body px-0 pb-0">
                                <div class="row no-gutters pb-3">
                                    <div class="col-4 pr-3">
                                        <img src="{{ asset(Storage::url($request->thumbnail)) }}"
                                            class="img-fluid rounded" alt="{{ $request->thumbnail_alt }}">
                                    </div>
                                    <div class="col-8 pl-3">
                                        <h5 class="mb-2">{{ $request->actualName }}</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="text-primary mb-0">Rs {{ $request->coursePrice }}</h4>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $coursePrice = $request->coursePrice;
                                    $sgst = $request->sgst;
                                    $cgst = $request->cgst;
                                    $payablePrice = $request->payablePrice;
                                    $slug = $request->name;
                                    $productType = $request->product_type;
                                @endphp
                                <livewire:promo-code :$coursePrice :$sgst :$cgst :$payablePrice :$productType :$slug />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 pl-lg-4 mt-4 mt-lg-0">
                    <div class="checkout-section custom-shadow" x-data="{ paymentMethod: true, signIn: false, verification: false, billingAddress: false }"
                        x-on:show-login-form.window="signIn = true; paymentMethod = false"
                        x-on:registration-success.window="signIn=false; paymentMethod = false; billingAddress = true;"
                        x-on:show-address-form.window="billingAddress = true; signIn = false; paymentMethod = false">
                        <div class="step-content" id="content-2" x-transition.duration.opacity x-show="signIn">
                            <h4 class="mb-3 text-dark">Sign In / Sign Up</h4>
                            <form action="{{ route('checkout.course') }}">
                                <input type="hidden" name="thumbnail" value="{{ $request->thumbnail }}">
                                <input type="hidden" name="thumbnail_alt" value="{{ $request->thumbnail_alt }}">
                                <input type="hidden" name="payable_price" value="{{ $request->payable_price }}">
                                <input type="hidden" name="product_type" value="{{ $request->product_type }}">
                                <input type="hidden" name="name" value="{{ $request->name }}">
                                <input type="hidden" name="actualName" value="{{ $request->actualName }}">
                                <input type="hidden" name="coursePrice" value="{{ $request->coursePrice }}">
                                <input type="hidden" name="cgst" value="{{ $request->cgst }}">
                                <input type="hidden" name="sgst" value="{{ $request->sgst }}">
                                <input type="hidden" name="payablePrice" value="{{ $request->payablePrice }}">
                                <button class="login-btn text-muted">Already Registered? <span>Login
                                        here<span></button>
                                @foreach ($course_schedule_values as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                            <livewire:register-user />
                        </div>
                        <form action="{{ route('payment.initiate') }}" x-ref="checkoutForm" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $request->name }}">
                            <div x-data="{ payablePrice: {{ $request->payablePrice }}, discount: 0, couponId: null }"
                                x-on:promo-code-applied.window="payablePrice = $event.detail.payablePrice; discount=$event.detail.discount; couponId=$event.detail.couponId">
                                <input type="hidden" name="payable_price" :value="payablePrice">
                                <input type="hidden" name="discount", :value="discount">
                                <input type="hidden" name="coupon_id" :value="couponId">
                            </div>
                            <input type="hidden" name="product_type" value="{{ $request->product_type }}">
                            <div class="step-content" id="content-1" x-transition.duration.opacity
                                x-show="paymentMethod">
                                <livewire:payment-method :$bankTransferDetails :$qrCode />
                            </div>
                        </form>
                        <div class="step-content" id="content-3" x-transition.duration.opacity
                            x-show="billingAddress">
                            <livewire:billing-address />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-frontend-layout>
