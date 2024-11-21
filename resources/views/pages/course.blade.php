<x-frontend-layout>
    @php
        $metaDetail = $course->metaDetail ?? ($package->metaDetail ?? null);
    @endphp
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
    <x-course-breadcrumb :$product />
    <section id="course-details" class="course-details-section">
        <div class="container">
            <div class="course-details-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="course-details-area">
                            <div class="course-details-content-wrapper">
                                <x-on-page-menu />
                                <x-overview :product />
                                <x-curriculum :product :$packageCourses />
                                <div id="schedule" class="zt-course-feature-box schedule-wrapper">
                                    <div class="section-title">
                                        <h4>Course Schedule</h4>
                                    </div>
                                    <!-- Course Schedule -->
                                    <div class="course-schedule-wrapper">
                                        <p class="course-schedule-wrapper-heading">Course Schedule</p>
                                        <div class="course-schedule-wrapper-body py-3">
                                            <div class="row m-0 align-items-center">
                                                <div class="col-12">
                                                    <x-schedule-card :product :$packageCourses />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ([$course ?? null, $package ?? null] as $item)
                                        @if ($item && $item->guideline)
                                            @foreach ($item->guideline as $guideline)
                                                <x-guideline :$guideline />
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                                <div id="study-material" class="zt-course-feature-box study-material-wrapper">
                                    <div class="section-title">
                                        <h4>Study Material</h4>
                                    </div>
                                    <div class="study-material-list mt-3">
                                        <div class="row">
                                            @foreach ([$course->studyMaterial ?? null] as $materials)
                                                @if ($materials)
                                                    @foreach ($materials as $material)
                                                        <x-study-material :$material />
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            @foreach ($packageCourses as $packageCourse)
                                                @foreach ($packageCourse->studyMaterial as $material)
                                                    @if ($material)
                                                        <x-study-material :$material />
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
                                            @foreach ([$course->faq ?? null, $package->faq ?? null] as $faqs)
                                                @if ($faqs)
                                                    @foreach ($faqs as $faq)
                                                        <x-faqs :$faq />
                                                    @endforeach
                                                @endif
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
