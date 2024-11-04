@if ($item->courses)
    <div class="modal zt-login-modal fade" id="checkoutpopup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="position-relative" data-background="assets/img/banner/lg-bg.jpg">
                    <div class="text-center pera-content">
                        <div class="modal-body text-left">
                            <form action="{{ route('payment.initiate') }}" method="POST">
                                @csrf
                                <h5 class="font-weight-bold">{{ $item->name }}</h5>
                                <h5>₹{{ $item->price }}/-</h5>
                                <p>CGST(9%) - ₹{{ $item->price * 0.09 }}</p>
                                <p>SGST(9%) - ₹{{ $item->price * 0.09 }}</p>
                                <h6>Total Price - ₹{{ $item->price + $item->price * 0.18 }}/-</h6>
                                @foreach ($packageCourses as $course)
                                    <div class="my-4">
                                        <label for="course-schedule">Select {{ $course->name }} Course Date &
                                            Time</label>
                                        <select class="form-control" name="course_schedule_{{ $course->id }}"
                                            id="course-schedule" required>
                                            <option value="" selected>select schedule</option>
                                            @foreach ($course->schedule as $schedule)
                                                <option
                                                    value="{{ $schedule->course->name }},{{ $schedule->start_date }} {{ $schedule->time }} {{ $schedule->training_mode }}">
                                                    {{ \Carbon\Carbon::parse($schedule->start_date)->format('jS M Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }} -
                                                    {{ $schedule->training_mode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                                <input type="hidden" name="amount" value="{{ $totalPrice }}" required>
                                <input type="hidden" name="product_type"
                                    value="{{ $item instanceof \App\Models\Course ? 'course' : 'package' }}" required>
                                <input type="hidden" name="name" value="{{ $item->slug }}" required>
                                <button class="btn btn-dark mb-2 w-100">Buy Now</button>
                                <p class="text-center">Share this course with your friends</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal zt-login-modal fade" id="checkoutpopup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="position-relative" data-background="assets/img/banner/lg-bg.jpg">
                    <div class="text-center pera-content">
                        <div class="modal-body text-left">
                            <form action="{{ route('payment.initiate') }}" method="POST">
                                @csrf
                                <h5 class="font-weight-bold">{{ $item->name }}</h5>
                                <h5>₹{{ $item->price }}</h5>
                                <p>CGST(9%) - ₹{{ $item->price * 0.09 }}</p>
                                <p>SGST(9%) - ₹{{ $item->price * 0.09 }}</p>
                                <h6>Total Price - ₹{{ $item->price + $item->price * 0.18 }}/-</h6>
                                <div class="pt-2">
                                    <label for="course-schedule">Select Your Course Date & Time</label>
                                    <select class="form-control" name="course_schedule" id="course-schedule" required>
                                        <option value="" selected>select schedule</option>
                                        @foreach ($item->schedule as $schedule)
                                            <option
                                                value="{{ $schedule->course->name }},{{ $schedule->start_date }} {{ $schedule->time }} {{ $schedule->training_mode }}">
                                                {{ \Carbon\Carbon::parse($schedule->start_date)->format('jS M Y') }} -
                                                {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }} -
                                                {{ $schedule->training_mode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="amount" value="{{ $totalPrice }}" required>
                                <input type="hidden" name="product_type"
                                    value="{{ $item instanceof \App\Models\Course ? 'course' : 'package' }}" required>
                                <input type="hidden" name="name" value="{{ $item->slug }}" required>
                                <button class="btn btn-dark mt-4 mb-2 w-100">Buy Now</button>
                                <p class="text-center">Share this course with your friends</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
