<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Checkout';
    @endphp
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
    <style>
        .form-control {
            position: relative;
        }

        .note p {
            color: #888888;
            font-size: 15px;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
        }

        .form-control:focus {
            border: 1px solid #fd5222;
        }

        .form-control i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
        }

        .checkout-lists {
            display: flex;
            flex-direction: column;
            row-gap: 15px;
            margin-bottom: 40px;
        }

        .card {
            display: flex;
            column-gap: 15px;
        }

        .card-image img {
            width: 100%;
            object-fit: fill;
            border-radius: 10px;
        }

        .card-name {
            font-weight: 600;
        }

        .card-details {
            padding: 1rem;
        }

        .card-details .card-price span {
            text-decoration: line-through;
            margin-left: 10px;
        }

        .checkout-shipping,
        .checkout-total {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-top: 1px solid #BDBDBD;
            height: 2rem;
        }

        button {
            background: #fd5222;
            color: white;
            border: 2px solid #fd5222;
            padding: 8px 32px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            margin: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        button:hover {
            background: #db3000;
            transform: translateY(-2px);
        }

        .login-btn {
            background-color: transparent;
            border: none;
            color: #555555;
            transform: none !important;
            padding: 0;
            margin: 0;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            background-color: transparent;
        }

        .login-btn span {
            color: #fd5222;
            text-decoration: underline;
        }

        .login-btn span:hover {
            color: #db3000;
            text-decoration: underline;
        }
    </style>
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <div class="container mt-5">
        @guest
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
                <button class="login-btn">Already Registered? <span>Login here<span></button>
                @foreach ($course_schedule_values as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                @endforeach
            </form>
        @endguest
        <main class="row">
            <!-- Checkout Form -->
            <section class="col-lg-6 col-md-6">
                <form action="{{ route('payment.initiate') }}" method="POST">
                    @csrf
                    <livewire:user-register />
                    @if (Auth::user() && Auth::user()->addresses && Auth::user()->email_verified_at)
                        <div class="pb-5 pt-3">
                            <h6>Select payment method: </h6>
                            <div class="row pb-3 px-5 justify-content-center">
                                <div class="form-check col-md-4 pl-5 payu-input">
                                    <input class="form-check-input payment-select" type="radio" value="payu"
                                        name="payment_method" id="payu" checked>
                                    <label class="form-check-label" for="payu">
                                        <img src="{{ asset('frontend/assets/img/icon/payu-icon.png') }}"
                                            alt="payu">
                                    </label>
                                </div>
                                <div class="form-check col-md-4 pl-5 paypal-input">
                                    <input class="form-check-input payment-select" type="radio" value="paypal"
                                        name="payment_method" id="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <img src="{{ asset('frontend/assets/img/icon/paypal-icon.png') }}"
                                            alt="paypal">
                                    </label>
                                </div>
                                <div class="form-check col-md-4 pl-5 stripe-input">
                                    <input class="form-check-input payment-select" type="radio" value="stripe"
                                        name="payment_method" id="stripe">
                                    <label class="form-check-label" for="stripe">
                                        <img src="{{ asset('frontend/assets/img/icon/stripe-icon.png') }}"
                                            alt="stripe">
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="payable_price" value="{{ $request->payable_price }}">
                            <input type="hidden" name="product_type" value="{{ $request->product_type }}">
                            <input type="hidden" name="name" value="{{ $request->name }}">
                            <button type="submit" class="btn btn-primary btn-block paynow-btn continue-btn border-0">
                                Pay Now
                            </button>
                        </div>
                    @endif
                </form>
            </section>

            <!-- Checkout Details -->
            <section class="col-lg-5 col-md-5 offset-lg-1 offset-md-1">
                <div class="bg-light p-4 rounded">
                    <div class="checkout-lists">
                        <div class="card border-0">
                            <div class="card-image">
                                <img src="{{ asset(Storage::url($request->thumbnail)) }}"
                                    alt="{{ $request->thumbnail_alt }}">
                            </div>
                            <div class="card-details">
                                <div class="card-name">{{ $request->actualName }}</div>
                                <div class="card-price">Rs {{ $request->coursePrice }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-shipping">
                        <h6>CGST</h6>
                        <p>Rs {{ $request->cgst }}</p>
                    </div>
                    <div class="checkout-shipping">
                        <h6>SGST</h6>
                        <p>Rs {{ $request->sgst }}</p>
                    </div>
                    <div class="checkout-total">
                        <h6>Total</h6>
                        <p>Rs {{ $request->payablePrice }}</p>
                    </div>
                    <div class="note">
                        {!! $thankyou->content !!}
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-frontend-layout>
