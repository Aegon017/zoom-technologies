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
                                <span class="font-weight-semibold">Sign In / Sign Up</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" id="step-2">
                                <div class="step-badge bg-light text-muted" data-step="2">2</div>
                                <span class="font-weight-semibold">Verification</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" id="step-3">
                                <div class="step-badge bg-light text-muted" data-step="3">3</div>
                                <span class="font-weight-semibold">Billing Address</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                            <div class="step-item" id="step-4">
                                <div class="step-badge bg-light text-muted" data-step="4">4</div>
                                <span class="text-muted">Payment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-5">
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
                            <div class="step-content" id="content-1">
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
                                    <button class="login-btn text-muted">Already Registered? <span>Login here<span></button>
                                    @foreach ($course_schedule_values as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                                    @endforeach
                                </form>
                                <livewire:register-user />
                            </div>
                        @endguest
                        @auth
                            @if (Auth::user()->email_verified_at === null)
                                <div class="step-content" id="content-2">
                                    <livewire:otp-verification />
                                </div>
                            @endif
                        @endauth
                        @auth
                            @if (Auth::user()->email_verified_at !== null)
                                <div x-data="{ expanded: false }" class="step-content" id="content-3">
                                    @if (Auth::user()->addresses)
                                        <div class="text-right" x-show="! expanded">
                                            <button class="btn btn-dark"
                                                x-on:click="expanded = ! expanded">Continue</button>
                                        </div>
                                    @endif
                                    <div x-show="! expanded">
                                        <livewire:billing-address />
                                    </div>
                                    @php
                                        $name = $request->name;
                                        $payablePrice = $request->payablePrice;
                                        $productType = $request->product_type;
                                    @endphp
                                    <div x-show="expanded" class="step-content" id="content-4">
                                        <livewire:payment-method :$name :$payablePrice :$productType />
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div x-on:reload-page.window="location.reload()"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const stepBadges = document.querySelectorAll('.step-badge');
                const steps = document.querySelectorAll('.step-item');
                const contents = document.querySelectorAll('.step-content');

                function activateStep(stepNumber) {
                    stepBadges.forEach(badge => badge.classList.remove('active'));
                    steps.forEach(step => step.classList.remove('active'));

                    const activeBadge = document.querySelector('.step-badge[data-step="' + stepNumber + '"]');
                    const activeStep = document.getElementById('step-' + stepNumber);

                    activeBadge?.classList.add('active');
                    activeStep?.classList.add('active');
                }

                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.5
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const stepNumber = entry.target.id.replace('content-', '');
                        if (entry.isIntersecting) {
                            activateStep(stepNumber);
                        }
                    });
                }, observerOptions);

                contents.forEach(content => {
                    observer.observe(content);
                });

                if (contents.length > 0) {
                    activateStep(1);
                }
            });
        </script>
</x-frontend-layout>
