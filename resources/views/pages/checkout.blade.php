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
                    <div class="card mb-4 border-radius-md">
                        <div class="card-header py-4 px-5 bg-orange text-white">
                            <h4 class="mb-0">Billing Address</h4>
                        </div>
                        <div class="card-body px-5 my-3">
                            <form>
                                {{-- <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control billing-fields" id="fullname"
                                            name="fullName" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control billing-fields" id="email"
                                            name="email" required>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control billing-fields" id="address" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control billing-fields" id="city"
                                            required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control billing-fields" id="state"
                                            required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="zip">Zip Code</label>
                                        <input type="text" class="form-control billing-fields" id="zip"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control billing-fields" id="country" required>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4 border-radius-md">
                        <div class="card-header bg-orange text-white py-4 px-5">
                            <h4 class="mb-0">Payment</h4>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <form>
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
                                <button type="submit"
                                    class="btn btn-primary btn-block paynow-btn continue-btn border-0">Pay
                                    Now</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-radius-md">
                        <div class="card-header bg-orange text-white py-4 px-5">
                            <h4 class="mb-0">Your Cart</h4>
                        </div>
                        <div class="card-body px-5 my-3">
                            <ul class="list-group mb-3">
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Product name</h6>
                                        <small class="text-muted">Brief description</small>
                                    </div>
                                    <span class="text-muted">$12</span>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Second product</h6>
                                        <small class="text-muted">Brief description</small>
                                    </div>
                                    <span class="text-muted">$8</span>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Third item</h6>
                                        <small class="text-muted">Brief description</small>
                                    </div>
                                    <span class="text-muted">$5</span>
                                </li>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between">
                                    <span>Total (USD)</span>
                                    <strong>$28</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
