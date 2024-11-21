<div class="modal zt-login-modal fade" id="checkoutpopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="position-relative" data-background="assets/img/banner/lg-bg.jpg">
                <div class="text-center pera-content">
                    <div class="modal-body text-left">
                        <form action="{{ route('payment.initiate') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="font-weight-bold text-heading">{{ $product->name }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-heading">Price:
                                        ₹{{ number_format($prices['salePrice'] ?? $prices['actualPrice']) }}</h5>
                                    <p class="text">CGST ({{ $prices['cgstPercentage'] }}%):
                                        ₹{{ number_format($prices['cgst']) }}</p>
                                    <p class="text">SGST ({{ $prices['sgstPercentage'] }}%):
                                        ₹{{ number_format($prices['sgst']) }}</p>
                                    <h5 class="text">Total: ₹{{ number_format($prices['payablePrice']) }}</h5>
                                </div>
                            </div>
                            @foreach ($packageCourses as $course)
                                <div class="my-4">
                                    <label for="course-schedule{{ $course->id }}">Select {{ $course->name }}
                                        Course Date & Time</label>
                                    <select class="form-control mb-2" name="course_schedule{{ $course->id }}"
                                        id="course-schedule{{ $course->id }}" required>
                                        <option value="" selected>select schedule</option>
                                        @foreach ($course->schedule as $schedule)
                                            <option value="{{ $schedule->id }}">
                                                {{ \Carbon\Carbon::parse($schedule->start_date)->format('jS M Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }} -
                                                {{ $schedule->training_mode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                            <input type="hidden" name="payable_price" value="{{ $prices['payablePrice'] }}">
                            <input type="hidden" name="product_type"
                                value="{{ $product->courses ? 'package' : 'course' }}">
                            <input type="hidden" name="name" value="{{ $product->slug }}">
                            <div class="payment-method">
                                <p class="font-weight-bold">Please select payment method</p>
                                <div class="row">
                                    <div class="form-check col-md-6 payu-input">
                                        <input class="form-check-input" type="radio" value="payu"
                                            name="payment_method" id="payu" checked>
                                        <label class="form-check-label" for="payu">
                                            <img src="{{ asset('frontend/assets/img/icon/payu-icon.png') }}"
                                                alt="payu">
                                        </label>
                                    </div>
                                    <div class="form-check col-md-6 paypal-input">
                                        <input class="form-check-input" type="radio" value="paypal"
                                            name="payment_method" id="paypal">
                                        <label class="form-check-label" for="paypal">
                                            <img src="{{ asset('frontend/assets/img/icon/paypal-icon.png') }}"
                                                alt="paypal">
                                        </label>
                                    </div>
                                    <div class="form-check col-md-6 stripe-input">
                                        <input class="form-check-input" type="radio" value="stripe"
                                            name="payment_method" id="stripe">
                                        <label class="form-check-label" for="stripe">
                                            <img src="{{ asset('frontend/assets/img/icon/stripe-icon.png') }}"
                                                alt="stripe">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-dark mb-2 w-100">Buy Now</button>
                            <p class="text-center">Share this course with your friends</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
