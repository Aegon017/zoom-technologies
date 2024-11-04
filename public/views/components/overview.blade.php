<div id="overview" class="zt-course-feature-box overview-wrapper">
    <div class="section-title">
        <h4>Overview</h4>
    </div>
    @isset($course)
        @if ($course->overview->uscouncil_certified)
            <div class="voucher-promo">
                <h4><img src="{{ asset('frontend/assets/img/us-council-logo-2.png') }}" alt="us-council"> Certified
                    {{ $course->name }}</h4>
            </div>
            <p><strong class="txt-primary">({{ $course->overview->note }})</strong>
            </p>
            <div class="voucher-promo">
                <h4><strong class="txt-primary">+FREE</strong> <img
                        src="{{ asset('frontend/assets/img/us-council-logo-2.png') }}" alt="us-council">
                    <strong>Certification Exam
                        Voucher</strong> -
                    Worth
                    <span class="txt-primary">${{ $course->overview->voucher_value }}</span>
                </h4>
            </div>
        @endif
        <p>
            {!! $course->overview->content !!}
        </p>
    @endisset
    @isset($package)
        @if ($package->overview->uscouncil_certified)
            <div class="certification-partner">
                <div class="wrapper">
                    <img src="{{ asset('frontend/assets/img/us-council-logo-2.png') }}" alt="US Council Logo">
                    <span class="txt">Certified {{ $package->name }} Course</span>
                </div>
            </div>
        @endif
        <p>
            {!! $package->overview->content !!}
        </p>
    @endisset
</div>
