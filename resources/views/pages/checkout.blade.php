<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Checkout';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <div class="checkout-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Buttons for user selection -->
                    <div class="d-flex justify-content-between mb-4">
                        @guest
                            <a href="{{ route('login') }}" class="px-5 py-3 bg-dark continue-btn">Already Registered</a>
                            <button type="button" class="btn bg-primary px-5 py-3 continue-btn" id="new-user-btn">New
                                User</button>
                        @endguest
                    </div>
                    <!-- New User Details Form -->
                    @guest
                        <div id="new-user-form" class="card mb-4 border-radius-md">
                            <div class="card-header py-4 px-5 bg-orange text-white">
                                <h4 class="mb-0">User Details</h4>
                            </div>
                            <div class="card-body px-5 my-3">
                                <form>
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control billing-fields" id="name"
                                            name="name" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control billing-fields" id="email"
                                                name="email" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="tel" class="form-control billing-fields" id="phone"
                                                name="phone" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endguest
                    <!-- Billing Address Form -->
                    <div class="card mb-4 border-radius-md">
                        <div class="card-header py-4 px-5 bg-orange text-white">
                            <h4 class="mb-0">Add Billing Address</h4>
                        </div>
                        <div class="card-body px-5 my-3">
                            <form action="{{ route('address.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control billing-fields" id="address"
                                        name="address" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control billing-fields" id="city"
                                            name="city" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control billing-fields" id="state"
                                            name="state" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="zip">Zip Code</label>
                                        <input type="text" class="form-control billing-fields" id="zip"
                                            name="zip_code" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control billing-fields" id="country"
                                        name="country" required>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-block continue-btn continue-btn border-0">Save</button>
                            </form>
                        </div>
                    </div>
                    <!-- Payment Section -->
                    <form action="{{ route('payment.initiate') }}" method="POST">
                        @csrf
                        @auth
                            @if (auth()->user())
                                <div class="card mb-4 border-radius-md">
                                    <div class="card-header py-4 px-5 bg-orange text-white">
                                        <h4 class="mb-0">Select Billing Address</h4>
                                    </div>
                                    <div class="card-body px-5 my-3">
                                        @csrf
                                        @foreach (auth()->user()->addresses as $address)
                                            <div class="form-check">
                                                <input class="form-check-input payment-select" type="radio"
                                                    name="selected_address" id="address_{{ $address->id }}"
                                                    value="{{ $address->id }}">
                                                <label class="form-check-label" for="address_{{ $address->id }}">
                                                    {{ $address->address }}, {{ $address->city }},
                                                    {{ $address->state }},
                                                    {{ $address->zip_code }}, {{ $address->country }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endauth
                        <div class="card mb-4 border-radius-md">
                            <div class="card-header bg-orange text-white py-4 px-5">
                                <h4 class="mb-0">Payment</h4>
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
                                <button type="submit"
                                    class="btn btn-primary btn-block paynow-btn continue-btn border-0">Pay
                                    Now</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side Cart Section -->
        <div class="col-md-4">
            <div class="card border-radius-md">
                <div class="card-header bg-orange text-white py-4 px-5">
                    <h4 class="mb-0">Your Cart</h4>
                </div>
                <div class="card-body px-5 my-3">
                    <ul class="list-group mb-3">
                        <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $request->actualName }}</h6>
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
        </div>
    </div>

    <!-- JavaScript for toggling forms -->
    <script>
        // JavaScript for form visibility toggle
        document.getElementById("new-user-btn").addEventListener("click", function() {
            document.getElementById("new-user-form").style.display = "block";
            document.getElementById("existing-user-btn").classList.remove("btn-secondary");
            document.getElementById("existing-user-btn").classList.add("btn-secondary");
        });

        document.getElementById("existing-user-btn").addEventListener("click", function() {
            document.getElementById("new-user-form").style.display = "none";
            document.getElementById("new-user-btn").classList.remove("btn-primary");
            document.getElementById("new-user-btn").classList.add("btn-secondary");
        });
    </script>
</x-frontend-layout>
