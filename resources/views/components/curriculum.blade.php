<div class="accordion-item">
    <div class="accordion-header">
        <h3>{{ $course->name }}</h3>
        <div class="cd-curriculam-time-lesson">
            <span>
                <a class="video_box text-center" href="{{ $course->video_link }}">
                    <i class="fas fa-play"></i>
                </a>
            </span>
            <span>
                <a href="{{ asset(Storage::url($course->outline_pdf)) }}" target="_blank">
                    <i class="fas fa-download"></i>
                </a>
            </span>
            <span>{{ $course->duration }} {{ $course->duration_type }}</span>
        </div>
    </div>
    <div class="accordion-content">
        @if ($course->overview->uscouncil_certified)
            <div class="voucher-promo">
                <h4>
                    <strong class="txt-primary">+FREE</strong>
                    <img src="{{ asset('frontend/assets/img/us-council-logo-2.png') }}" alt="us-council">
                    <strong>Certification Exam Voucher</strong> -
                    <span class="txt-primary">worth ${{ $course->overview->voucher_value }}</span>
                </h4>
            </div>
        @endif

        <div class="accordion">
            @foreach ($course->curriculum as $curriculum)
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Module {{ $loop->iteration }}: {{ $curriculum->module_name }}</h3>
                    </div>
                    <div class="accordion-content">
                        {!! $curriculum->module_content !!}
                        @foreach ($curriculum->subcurriculum as $sub)
                            <div class="accordion">
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <h3>{{ $sub->module_name }}</h3>
                                    </div>
                                    <div class="accordion-content">
                                        {!! $sub->module_content !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
