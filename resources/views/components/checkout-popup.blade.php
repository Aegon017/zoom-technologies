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
                                <p>CGST({{ App\Models\Tax::where('name', 'CGST')->first()->rate }}%) -
                                    ₹{{ ($item->price * App\Models\Tax::where('name', 'CGST')->first()->rate) / 100 }}
                                </p>
                                <p>SGST({{ App\Models\Tax::where('name', 'SGST')->first()->rate }}%) -
                                    ₹{{ ($item->price * App\Models\Tax::where('name', 'SGST')->first()->rate) / 100 }}
                                </p>
                                <h6>Total Price -
                                    ₹{{ $item->price + ($item->price * (App\Models\Tax::where('name', 'CGST')->first()->rate + App\Models\Tax::where('name', 'SGST')->first()->rate)) / 100 }}/-
                                </h6>
                                @foreach ($packageCourses as $course)
                                    <div class="my-4">
                                        <label for="course-schedule">Select {{ $course->name }} Course Date &
                                            Time</label>
                                        <select class="form-control" name="course_schedule{{ $course->id }}"
                                            id="course-schedule" required>
                                            <option value="" selected>select schedule</option>
                                            @foreach ($course->schedule as $schedule)
                                                <option value="{{ $schedule->id }}">
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
                                <h5>₹{{ $item->original_price ? $item->original_price : $item->price }}</h5>
                                <p>CGST({{ App\Models\Tax::where('name', 'CGST')->first()->rate }}%) -
                                    ₹{{ (($item->original_price ? $item->original_price : $item->price) * App\Models\Tax::where('name', 'CGST')->first()->rate) / 100 }}
                                </p>
                                <p>SGST({{ App\Models\Tax::where('name', 'SGST')->first()->rate }}%) -
                                    ₹{{ (($item->original_price ? $item->original_price : $item->price) * App\Models\Tax::where('name', 'SGST')->first()->rate) / 100 }}
                                </p>
                                <h6>Total Price -
                                    ₹{{ ($item->original_price ? $item->original_price : $item->price) + (($item->original_price ? $item->original_price : $item->price) * (App\Models\Tax::where('name', 'CGST')->first()->rate + App\Models\Tax::where('name', 'SGST')->first()->rate)) / 100 }}/-
                                </h6>
                                <div class="pt-2">
                                    <label for="course-schedule">Select Your Course Date & Time</label>
                                    <select class="form-control" name="course_schedule" id="course-schedule" required>
                                        <option value="" selected>select schedule</option>
                                        @foreach ($item->schedule as $schedule)
                                            <option value="{{ $schedule->id }}">
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
