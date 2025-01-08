<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Your Study Materials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section id="course-page-course" class="course-page-course-section">
        <div class="container">
            <div class="course-page-course-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <p class="title-watermark">Study Materials</p>
                    <span>Study Materials</span>
                    <h2>Study Materials</h2>
                </div>
                <div class="zt-course-content-3">
                    <div class="row justify-content-center">
                        <div class="zt-course-content-3">
                            <section id="zt-cta-4" class="zt-cta-section-4 study-material p-0">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="zt-feature-innerbox position-relative">
                                                <div class="zt-feature-icon float-left">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                                <div class="zt-feature-text zt-headline pera-content">
                                                    <h3><a href="#">Free Study Material</a></h3>
                                                    <p>Free Study Material! Presentations, Lab Manual &amp; Workbooks
                                                    </p>
                                                    <a href="{{ route('render.student.studyMaterials.type', 'free') }}"
                                                        class="zt-feature-button">Access Now<i
                                                            class="fa fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="zt-feature-innerbox position-relative">
                                                <div class="zt-feature-icon float-left">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                                <div class="zt-feature-text zt-headline pera-content">
                                                    <h3><a href="#">Paid Study Material</a></h3>
                                                    <p>Paid Study Material! Presentations, Lab Manual &amp; Workbooks
                                                    </p>
                                                    <a href="{{ route('render.student.studyMaterials.type', 'paid') }}"
                                                        class="zt-feature-button">Access Now<i
                                                            class="fa fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</x-frontend-layout>
