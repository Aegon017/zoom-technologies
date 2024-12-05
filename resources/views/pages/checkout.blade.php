<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Checkout';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <div class="checkout-section py-5" x-data="{ selectedAddress: '' }">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Buttons for user selection -->
                    <div class="d-flex justify-content-between mb-4 gap-5">
                        @guest
                            <a href="{{ route('login') }}" class="px-3 py-2 bg-dark continue-btn">Already Registered</a>
                            <button type="button" class="btn px-3 py-2 continue-btn" id="new-user-btn">New
                                User</button>
                        @endguest
                    </div>
                    <!-- New User Details Form -->
                    <livewire:user-register />
                    <!-- Payment Section -->
                    <form action="{{ route('payment.initiate') }}" method="POST">
                        @csrf
                        <livewire:user-address />
                        <div class="card mb-4 border-radius-md">
                            <div class="card-header bg-orange text-white py-3 px-5">
                                <h5 class="mb-0 text-orange">Payment</h5>
                            </div>
                            <div class="card-body px-5 pb-5">
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
                                <button :disabled="!selectedAddress" type="submit"
                                    class="btn btn-primary btn-block paynow-btn continue-btn border-0">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Side Cart Section -->
                <div class="col-md-4">
                    <div class="card border-radius-md">
                        <div class="card-header bg-orange text-white py-3 px-5">
                            <h5 class="mb-0 text-orange">Your Cart</h5>
                        </div>
                        <div class="card-body px-5 my-3">
                            <ul class="list-group mb-3">
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0 font-weight-bold text-balance">{{ $request->actualName }}</h6>
                                    </div>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Sub Total</h6>
                                    </div>
                                    <span class="text-muted">Rs {{ $request->coursePrice }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">CGST</h6>
                                    </div>
                                    <span class="text-muted">Rs {{ $request->cgst }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">SGST</h6>
                                    </div>
                                    <span class="text-muted">Rs {{ $request->sgst }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between">
                                    <span>Total</span>
                                    <strong>Rs {{ $request->payablePrice }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        {!! $thankyou->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-toggle="tooltip"]').forEach(function(element) {
                new bootstrap.Tooltip(element);
            });
        });
    </script>
</x-frontend-layout>
