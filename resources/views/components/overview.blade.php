<div id="overview" class="zt-course-feature-box overview-wrapper">
    <div class="section-title">
        <h4>Overview</h4>
    </div>
    @if ($product->overview?->uscouncil_certified)
        <div class="voucher-promo">
            <h4><img src="{{ asset('frontend/assets/img/us-council-logo-2.png') }}" alt="us-council"> Certified
                {{ $product->name }}</h4>
        </div>
        @if ($product->overview->note)
            <p><strong class="txt-primary">({{ $product->overview->note }})</strong></p>
        @endif
        @if ($product->overview->voucher_value)
            <div class="voucher-promo">
                <h4><strong class="txt-primary">+FREE</strong> <img
                        src="{{ asset('frontend/assets/img/us-council-logo-2.png') }}" alt="us-council">
                    <strong>Certification Exam Voucher</strong> - Worth
                    <span class="txt-primary">${{ $product->overview->voucher_value }}</span>
                </h4>
            </div>
        @endif
    @endif
    {!! $product->overview->content ?? '' !!}
</div>
