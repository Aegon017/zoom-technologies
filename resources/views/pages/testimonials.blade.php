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
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Testimonials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper testimonials-page">
        <div class="container">
            <div class="row">
                @foreach ($testimonials as $testimonial)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="zt-testimonial-item" style="height: auto;">
                            <div class="user-info">
                                <h3 class="name">{{ $testimonial->name }}</h3>
                                <h5 class="designation">{{ $testimonial->location }}</h5>
                            </div>
                            <div class="inner-content-wrapper">
                                <div class="user-review" style="max-height: 100px;">
                                    <p>{!! $testimonial->content !!}</p>
                                </div>
                                <span class="button">Read more<i class="fas fa-angle-double-right"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
