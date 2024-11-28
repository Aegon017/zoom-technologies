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

    @if ($pageSchema != null)
        <x-slot:localSchema>
            {!! $pageSchema->local_schema !!}
        </x-slot>
        <x-slot:organizationSchema>
            {!! $pageSchema->organization_schema !!}
        </x-slot>
    @endif
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Memorable Moments';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper memorable-moments-page">
        <div class="container">
            <div class="masonry-grid">
                @foreach ($moments as $moment)
                    <div class="grid-item image-text-card">
                        <div class="img">
                            <a class="zt-photo-popup" data-lightbox="mmoments"
                                href="{{ asset(Storage::url($moment->image)) }}">
                                <img src="{{ asset(Storage::url($moment->image)) }}" alt="{{ $moment->image_alt }}">
                            </a>
                        </div>
                        <div class="content">
                            <p>{{ $moment->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
