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
        $pageTitle = 'Certificates';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @foreach ($certificates as $certificate)
                        <div class="content-wrapper p-5 mb-5">
                            <div class="px-3 pb-3 row justify-content-between">
                                @foreach ($certificate->schedule as $cert)
                                    <h5>{{ $cert->course->name }}</h5>
                                @endforeach
                                {{-- <a href="{{ route('download.certificate') }}" class="btn btn-dark">Download</a> --}}
                            </div>
                            <x-certificate-pdf :$certificate :$cert :$companyAddress />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
