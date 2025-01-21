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
                    <div class="content-wrapper p-5">
                        <div class="px-3 pb-3 row justify-content-between">
                            <h5>Course Name</h5>
                            <a href="" class="btn btn-dark">Download</a>
                        </div>
                        <x-certificate-pdf />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
