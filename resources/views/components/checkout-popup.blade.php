<div class="modal zt-login-modal fade" id="checkoutpopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close model-cross" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="position-relative">
                <div class="text-center pera-content">
                    <div class="modal-body text-left">
                        <form action="{{ route('checkout') }}">
                            @foreach ($packageCourses as $course)
                                <div class="my-3">
                                    <label for="course-schedule" class="batch-label">Select {{ $course->name }}
                                        Batch</label>
                                    <select class="form-control mb-2 batch-select"
                                        name="course_schedule{{ $course->id }}"
                                        id="course-schedule{{ $course->id }}" required>
                                        <option value="" selected>select schedule</option>
                                        @foreach ($course->schedule as $schedule)
                                            @if ($schedule->status == true)
                                                <option value="{{ $schedule->id }}">
                                                    {{ \Carbon\Carbon::parse($schedule->start_date)->format('jS M Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}
                                                    ({{ $schedule->timezone?->abbreviation }} -
                                                    {{ $schedule->timezone?->offset }})
                                                    -
                                                    {{ $schedule->training_mode }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                            <input type="hidden" name="payable_price" value="{{ $prices['payablePrice'] }}">
                            <input type="hidden" name="product_type"
                                value="{{ $product->courses ? 'package' : 'course' }}">
                            <input type="hidden" name="name" value="{{ $product->slug }}">
                            <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}">
                            <input type="hidden" name="thumbnail_alt" value="{{ $product->thumbnail_alt }}">
                            <input type="hidden" name="actualName" value="{{ $product->name }}">
                            <input type="hidden" name="coursePrice"
                                value="{{ $prices['salePrice'] ?? $prices['actualPrice'] }}">
                            <input type="hidden" name="cgst" value="{{ $prices['cgst'] }}">
                            <input type="hidden" name="sgst" value="{{ $prices['sgst'] }}">
                            <input type="hidden" name="payablePrice" value="{{ $prices['payablePrice'] }}">
                            <button class="btn mb-3 w-100 continue-btn">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
