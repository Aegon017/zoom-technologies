<x-frontend-layout>
    @if ($metaDetail != null)
        <x-slot:metaTitle>
            {{ $metaDetail->title }}
        </x-slot>
        <x-slot:metaKeywords>
            {{ $metaDetail->keywords }}
        </x-slot>
        <x-slot:metaDescription>
            {{ $metaDetail->description }}
        </x-slot>
    @endif
    <x-slot:localSchema>
        {!! $pageSchema?->local_schema !!}
    </x-slot>
    <x-slot:organizationSchema>
        {!! $pageSchema?->organization_schema !!}
    </x-slot>
    @if ($sliders)
        <section id="zt-slider-2" class="zt-slider-section-2">
            <div id="zt-main-slider-2" class="zt-main-slider-wrap owl-carousel">
                @foreach ($sliders as $slider)
                    <div class="slider-main-item-2 position-relative">
                        <div class="slider-main-img img-zooming"
                            data-background="{{ asset(Storage::url($slider->image)) }}">
                        </div>
                        <div class="slider-overlay"></div>
                        <div class="container">
                            <div class="slider-main-text zt-headline text-center pera-content">
                                <h1>
                                    {{ $slider->title }}
                                </h1>
                                {!! $slider->content !!}
                                <a href="{{ $slider->redirect_url }}" class="slide-btn">{{ $slider->button_name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    @if ($promoSections)
        <section class="zt-promo-section">
            <div class="container">
                <div class="zt-promo zt-promo-carousel owl-carousel">
                    @foreach ($promoSections as $promoSection)
                        <div class="zt-promo-item">
                            <a href="{{ $promoSection->redirect_link }}">
                                <div class="wrapper">
                                    <h3>{{ $promoSection->title }}</h3>
                                    <p>{!! $promoSection->content !!}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if ($featureSection)
        <section id="zt-feature" class="zt-feature-section zt-why-choose-us">
            <div class="container">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <span>{{ $featureSection->title }}</span>
                    <h2>{{ $featureSection->heading }}</h2>
                    <p>{!! $featureSection->content !!}</p>
                </div>
                <div class="zt-feature-content">
                    <div class="row justify-content-center wow fadeInUp" data-wow-delay="0ms"
                        data-wow-duration="1500ms">
                        @if ($featureCards)
                            @foreach ($featureCards as $featureCard)
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="zt-feature-innerbox position-relative">
                                        <div class="zt-feature-icon">
                                            {!! $featureCard->icon !!}
                                        </div>
                                        <div class="zt-feature-text zt-headline pera-content">
                                            @if ($featureCard->number)
                                                <h3><span class="odometer"
                                                        data-count="{{ $featureCard->number }}">00</span><sup>+</sup>
                                                </h3>
                                            @endif
                                            <h4>{{ $featureCard->title }}</h4>
                                            <p>{{ $featureCard->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    <x-featured-courses />
    @if ($freeMaterials)
        <section id="zt-cta-4" class="zt-cta-section-4 study-material bg-white">
            <div class="container">
                <div class="row">
                    @foreach ($freeMaterials as $freeMaterial)
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="zt-feature-innerbox position-relative">
                                <div class="zt-feature-icon float-left">
                                    {!! $freeMaterial->icon !!}
                                </div>
                                <div class="zt-feature-text zt-headline pera-content">
                                    <h3><a href="#">{{ $freeMaterial->title }}</a></h3>
                                    <p>{{ $freeMaterial->content }}</p>
                                    <a href="{{ $freeMaterial->redirect_url }}"
                                        class="zt-feature-button">{{ $freeMaterial->button_name }}<i
                                            class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if ($testimonialSection)
        <section id="zt-testimonial" class="zt-testimonial-section"
            data-background="{{ asset(Storage::url($testimonialSection->image)) }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="zt-section-title zt-headline zt-title-style-two position-relative">
                            <span>{{ $testimonialSection->title }}</span>
                            <h2>{{ $testimonialSection->heading }}</h2>
                        </div>
                        <div class="zt-testimonial-content">
                            <div id="zt-testimonial-slide" class="zt-testimonial-area owl-carousel">
                                @foreach ($testimonials as $testimonial)
                                    <div class="zt-testimonial-item-wrap pera-content zt-headline">
                                        <div class="testimonial-content">
                                            {!! $testimonial->content !!}
                                        </div>
                                        <div class="zt-testimonial-author">
                                            <div class="zt-testimonial-text">
                                                <div class="zt-testimonial-rate ul-li">
                                                    <ul>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                    </ul>
                                                </div>
                                                <h4><a href="#">{{ $testimonial->name }}</a></h4>
                                                <span>{{ $testimonial->location }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('render.testimonials') }}" class="zt-btn-style-1 mt-3">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if ($aboutUsSection)
        <section id="about" class="about-page-about-section">
            <div class="container">
                <div class="about-page-about-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="about-page-about-img">
                                <img src="{{ asset(Storage::url($aboutUsSection->image)) }}"
                                    alt="{{ $aboutUsSection->image_alt }}">
                                <a class="video_box text-center" href="{{ $aboutUsSection->video_url }}"><i
                                        class="fas fa-play"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-page-about-text">
                                <div class="zt-section-title  zt-headline zt-title-style-two position-relative">
                                    <span>{{ $aboutUsSection->title }}</span>
                                    <h2>{{ $aboutUsSection->heading }}</h2>
                                </div>
                                <div class="about-page-about-text-wrap">
                                    {!! $aboutUsSection->content !!}
                                </div>
                            </div>
                            @if ($brochures)
                                <div class="button-group">
                                    @foreach ($brochures as $brochure)
                                        <a href="{{ asset(Storage::url($brochure->brochure)) }}" target="_blank"
                                            class="zt-btn-download"><i
                                                class="fas fa-file-pdf"></i>{{ $brochure->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if ($clients)
        <section class="zt-corporate-training">
            <div class="container">
                <div class="zt-section-title text-center">
                    <h2>Corporate Training</h2>
                </div>
                <div class="zt-client-logo-wrapper">
                    <div class="zt-client-logos zt-client-logo-carousel owl-carousel">

                        @foreach ($clients as $client)
                            <div class="zt-client-logo-item">
                                <a href="{{ $client->redirect_url }}">
                                    <img src="{{ asset(Storage::url($client->image)) }}"
                                        alt="{{ $client->image_alt }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if ($faqs)
        <section class="mb-5 faq-section">
            <div class="container">
                <div class="zt-section-title text-center">
                    <h2>FAQ'S</h2>
                </div>
                <div class="accordion faq-accordion">
                    @foreach ($faqs as $faq)
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h3>{{ $faq->question }}</h3>
                            </div>
                            <div class="accordion-content">{!! $faq->answer !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-frontend-layout>
