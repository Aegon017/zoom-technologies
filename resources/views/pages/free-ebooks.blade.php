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
        $pageTitle = 'Free Study Materials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    @if ($pageContent)
        <section class="zt-inner-page-wrapper e-books-page">
            <div class="container">
                @foreach ($pageContent as $data)
                    <div class="e-books-wrapper bg-white d-block w-100 p-4 mb-4">
                        <div class="e-books-content d-block mb-4 position-relative text-center">
                            <h3 class="text-primary text-center mb-4">{{ $data['heading'] }}</h3>
                            {!! $data['content'] !!}
                        </div>
                        @if ($loop->iteration === 1)
                            <div class="zt-ebooks-list d-block w-100 position-relative">
                                <div class="row">
                                    @foreach ($materials as $material)
                                        <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 mb-4">
                                            <div class="study-material-item">
                                                <a href="{{ $material->material_pdf ? asset(Storage::url($material->material_pdf)) : $material->material_url }}"
                                                    target="{{ $material->material_pdf ? '_blank' : '_self' }}">
                                                    <img src="{{ asset(Storage::url($material->image)) }}"
                                                        alt="{{ $material->image_alt }}">
                                                    <div class="study-material-content">
                                                        <h3>{{ $material->name }}</h3>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    <x-related-courses />
</x-frontend-layout>
