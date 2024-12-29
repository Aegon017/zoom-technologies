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
        $pageTitle = 'Franchisee';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    @if ($pageContent)
        <section class="zt-inner-page-wrapper e-books-page">
            <div class="container">
                <div class="content-wrapper bg-white d-block w-100">
                    @foreach ($pageContent as $data)
                        <h3 class="zt-sub-title">{{ $data['heading'] }}</h3>
                        <p>{!! $data['content'] !!}</p>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <x-related-courses />
</x-frontend-layout>
