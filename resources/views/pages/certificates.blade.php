<x-frontend-layout>
    <style>
        .border-radius-md {
            border-radius: 1rem;
        }

        .course-card {
            height: 12rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
        }

        .batch-date,
        .batch-time {
            font-size: 0.9rem;
            color: #007bff;
        }
    </style>

    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Certificates';
    @endphp

    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />

    <section id="course-page-course" class="course-page-course-section">
        <div class="container">
            <div class="course-page-course-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <p class="title-watermark">Certificates</p>
                    <span>Certificates</span>
                    <h2>Your Certificates</h2>
                </div>
                <div class="zt-course-content-3">
                    <div class="row">
                        @foreach ($certificates as $certificate)
                            <div class="col-lg-4 mb-4">
                                <div class="card p-3 border-radius-md course-card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">{{ $certificate->schedule->course->name }}</h5>
                                        <a href="{{ asset($certificate->certificate_path) }}" class="btn btn-dark"
                                            target="_blank" rel="noopener noreferrer">Download</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-related-courses />
</x-frontend-layout>
