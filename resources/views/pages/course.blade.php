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
    <x-course-breadcrumb :$course :$package />
    <section id="course-details" class="course-details-section">
        <div class="container">
            <div class="course-details-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="course-details-area">
                            <div class="course-details-content-wrapper">
                                <x-on-page-menu />
                                <x-overview :$course :$package />
                                <x-curriculum :$course :$package :$packageCourses />
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
                                                    <x-schedule-card :$course :$package :$packageCourses />
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
                                            @foreach ([$course->studyMaterial ?? null, $package->studyMaterial ?? null] as $materials)
                                                @if ($materials)
                                                    @foreach ($materials as $material)
                                                        <x-study-material :$material />
                                                    @endforeach
                                                @endif
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
                        @foreach ([$course, $package] as $item)
                            @if ($item)
                                <x-course-widget :$item />
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
    @foreach ([$course, $package] as $item)
        @if ($item)
            @php
                $totalPrice = ($item->original_price ? $item->original_price : $item->price) * 1.18;
            @endphp
            <x-checkout-popup :$item :$totalPrice :$packageCourses />
        @endif
    @endforeach
</x-frontend-layout>
