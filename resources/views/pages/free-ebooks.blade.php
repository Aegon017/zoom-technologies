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
        $pageTitle = 'Free Study Materials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper e-books-page">
        <div class="container">
            <div class="e-books-wrapper bg-white d-block w-100 p-4 mb-4">
                <div class="e-books-content d-block mb-4 position-relative text-center">
                    <h3 class="text-primary text-center mb-4">Free Study Material</h3>
                    <p>Welcome to the course contents page. We have uploaded all the course presentations and lab manual
                        /
                        workbooks here for your benefit. You get unlimited free access to all the lab workbooks of all
                        courses taught at Zoom. <strong>Please note, these Study Material can only be viewed, not
                            downloaded.</strong></p>
                    <p><strong>Remember, if you register for a course with us, our instructors will lead you through
                            each
                            and every exercise in the lab manual.</strong></p>
                </div>
                <div class="zt-ebooks-list d-block w-100 position-relative">
                    <div class="row">
                        @foreach ($materials as $material)
                            <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 mb-4">
                                <div class="study-material-item">
                                    <a href="{{ $material->material_url }}">
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
            </div>
            <div id="free-videos" class="free-video-wrapper bg-white d-block w-100 p-4">
                <div class="e-books-content d-block mb-4 position-relative text-center">
                    <h3 class="text-primary text-center mb-4">Training Videos Download</h3>
                    <p><strong>Training Videos can be Downloads FREE once you register for any course.</strong></p>
                    <p>ZOOM Technologies provides free and open access to all our material and videos of all our courses
                        taught by our expert engineers. All lectures are recorded from Live Online classroom sessions
                        with
                        the participants interacting with the instructor.</p>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
