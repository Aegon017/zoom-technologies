<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Study Materials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper e-books-page">
        <div class="container">
            <div class="e-books-wrapper bg-white d-block w-100 p-4 mb-4">
                <div class="e-books-content d-block mb-4 position-relative text-center">
                    <h3 class="text-primary text-center mb-4">{{ $courseName }}</h3>
                    {{-- <p>Welcome to the course contents page. We have uploaded all the course presentations and lab manual
                        /
                        workbooks here for your benefit. You get unlimited free access to all the lab workbooks of all
                        courses taught at Zoom. <strong>Please note, these Study Material can only be viewed, not
                            downloaded.</strong></p>
                    <p><strong>Remember, if you register for a course with us, our instructors will lead you through
                            each
                            and every exercise in the lab manual.</strong></p> --}}
                </div>
                <div class="zt-ebooks-list d-block w-100 position-relative">
                    <div class="row">
                        @foreach ($studyMaterials as $studyMaterial)
                            <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 mb-4">
                                <div class="study-material-item">
                                    <a href="{{ $studyMaterial->material_url }}">
                                        <img src="{{ asset(Storage::url($studyMaterial->image)) }}"
                                            alt="{{ $studyMaterial->image_alt }}">
                                        <div class="study-material-content">
                                            <h3>{{ $studyMaterial->name }}</h3>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- <div id="free-videos" class="free-video-wrapper bg-white d-block w-100 p-4">
                <div class="e-books-content d-block mb-4 position-relative text-center">
                    <h3 class="text-primary text-center mb-4">Training Videos Download</h3>
                    <p><strong>Training Videos can be Downloads FREE once you register for any course.</strong></p>
                    <p>ZOOM Technologies provides free and open access to all our material and videos of all our courses
                        taught by our expert engineers. All lectures are recorded from Live Online classroom sessions
                        with
                        the participants interacting with the instructor.</p>
                </div>
            </div> --}}
        </div>
    </section>
</x-frontend-layout>
