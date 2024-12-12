{{-- <x-frontend-layout>
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
    </div>
</x-frontend-layout> --}}
<x-frontend-layout>
    <style>
        /* Custom styling to mimic Tailwind-like appearance */
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

        .product-card {
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .checkout-section {
            background-color: white;
            border-radius: 0.5rem;
            padding: 2rem;
        }

        .text-underline {
            text-decoration: underline;
        }

        .btn-orange {
            color: white;
            background-color: #fd5222;
            border: none;
            border-radius: 0.5rem;
            padding: 0.7rem 2.5rem;

        }

        .btn-orange:hover {
            background-color: #cc3309;
        }
    </style>
    <title>Enhanced Checkout</title>
    </head>

    <body x-data="{ activeTab: 1 }">
        <div class="container-fluid bg-white shadow-sm py-3 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <a href="#" class="h2 font-weight-bold text-dark">Checkout</a>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="step-indicator">
                            <div class="step-item" @click="activeTab = 1">
                                <div class="step-badge bg-success text-white">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="font-weight-semibold">Sign In / Sign Up</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" @click="activeTab = 2">
                                <div class="step-badge bg-primary text-white">2</div>
                                <span class="font-weight-semibold">Verification</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" @click="activeTab = 3">
                                <div class="step-badge bg-primary text-white">3</div>
                                <span class="font-weight-semibold">Billing Address</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" @click="activeTab = 4">
                                <div class="step-badge bg-light text-muted">4</div>
                                <span class="text-muted">Payment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 pr-lg-4">
                    <div class="checkout-section custom-shadow">
                        <h4 class="mb-3 text-dark">Order Summary</h4>
                        <p class="text-muted">Check your items. And select a suitable shipping method.</p>
                        <div class="product-card card mb-3 overflow-hidden custom-shadow">
                            <div class="card-body">
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
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Subtotal</span>
                                        <span>Rs {{ $request->coursePrice }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>CGST</span>
                                        <span>Rs {{ $request->cgst }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>SGST</span>
                                        <span>Rs {{ $request->sgst }}</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between font-weight-bold">
                                    <span>Total</span>
                                    <span>Rs {{ $request->payablePrice }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 pl-lg-4 mt-4 mt-lg-0">
                    <div class="checkout-section custom-shadow">
                        @guest
                            <div x-show="activeTab === 1">
                                <livewire:register-user />
                            </div>
                        @endguest
                        @auth
                            @if (Auth::user()->email_verified_at === null)
                                <div x-show="activeTab === 2">
                                    <livewire:otp-verification />
                                </div>
                            @endif
                        @endauth
                        @auth
                            @if (Auth::user()->email_verified_at !== null)
                                <div x-show="activeTab === 3">
                                    <livewire:billing-address />
                                </div>
                            @endif
                        @endauth
                        @auth
                            @php
                                $name = $request->name;
                                $payablePrice = $request->payablePrice;
                                $productType = $request->product_type;
                            @endphp
                            <div x-show="activeTab === 4">
                                <livewire:payment-method :$name :$payablePrice :$productType />
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <script>
            Livewire.on('reload-page', () => {
                window.location.reload();
            });
        </script>
</x-frontend-layout>
