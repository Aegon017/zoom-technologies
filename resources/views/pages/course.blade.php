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
    <x-course-breadcrumb :$product />
    <section id="course-details" class="course-details-section">
        <div class="container">
            <div class="course-details-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="course-details-area">
                            <div class="course-details-content-wrapper">
                                <x-on-page-menu />
                                <x-overview :$product />
                                <div id="curriculum" class="zt-course-feature-box curriculum-wrapper">
                                    <div class="section-title">
                                        <h4>Curriculum</h4>
                                    </div>

                                    <div class="accordion">
                                        @foreach ($packageCourses as $course)
                                            <x-curriculum :$course />
                                        @endforeach
                                    </div>
                                </div>
                                <div id="schedule" class="zt-course-feature-box schedule-wrapper">
                                    <div class="section-title">
                                        <h4>Course Schedule</h4>
                                    </div>
                                    <div class="course-schedule-wrapper">
                                        <p class="course-schedule-wrapper-heading">Course Schedule</p>
                                        <div class="course-schedule-wrapper-body py-3">
                                            <div class="row m-0 align-items-center">
                                                <div class="col-12">
                                                    @foreach ($packageCourses as $course)
                                                        <h6 class="p-3 mt-3">{{ $course->name }}</h6>
                                                        <div class="row m-0 batch-list">
                                                            @foreach ($course->schedule as $schedule)
                                                                <x-schedule-card :$schedule />
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($product->guideline as $guideline)
                                        <x-guideline :$guideline />
                                    @endforeach
                                </div>
                                <div id="sample-certificate" class="zt-course-feature-box sample-certificate-wrapper">
                                    <div class="section-title">
                                        <h4>Sample Certificate</h4>
                                    </div>
                                    @foreach ($packageCourses as $course)
                                        @php
                                            $certificate = $course->sampleCertificate;
                                        @endphp
                                        <div class="sample-certificate-list mb-5">
                                            <h6>{{ $course->name }}</h6>
                                            <x-sample-certificate :$certificate />
                                        </div>
                                    @endforeach
                                </div>
                                <div id="study-material" class="zt-course-feature-box study-material-wrapper">
                                    <div class="section-title">
                                        <h4>Study Material</h4>
                                    </div>
                                    <div class="study-material-list mt-3">
                                        <div class="row">
                                            @foreach ($packageCourses as $course)
                                                @foreach ($course->studyMaterial as $studyMaterial)
                                                    @if ($studyMaterial->subscription === 'Free')
                                                        <x-study-material :$studyMaterial />
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div id="course-faq" class="zt-course-feature-box course-faq-wrapper">
                                    <div class="section-title">
                                        <h4>FAQ'S</h4>
                                    </div>
                                    <div class="study-material-list faq=list mt-3">
                                        <div class="accordion faq-accordion">
                                            @foreach ($product->faq as $faq)
                                                <x-faqs :$faq />
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <x-course-widget :$prices :$product />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
    <x-checkout-popup :$prices :$product :$packageCourses />
</x-frontend-layout>
