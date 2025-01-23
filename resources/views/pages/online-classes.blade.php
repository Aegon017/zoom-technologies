<x-frontend-layout>
    <style>
        .border-radius-md {
            border-radius: 1rem;
        }

        .course-card {
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
        }

        .batch-date,
        .batch-time {
            font-size: 0.9rem;
            color: #4a4a4a;
            font-weight: 500;
        }

        .icon {
            margin-right: 0.5rem;
        }

        .meeting-link {
            color: #fd640e;
            text-decoration: none;
        }

        .meeting-link:hover {
            text-decoration: underline;
        }

        .title-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 5rem;
            color: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .zt-section-title {
            position: relative;
            z-index: 2;
        }
    </style>

    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Online Classes';
    @endphp

    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />

    <section id="course-page-course" class="course-page-course-section">
        <div class="container">
            <div class="course-page-course-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <p class="title-watermark">Online Classes</p>
                    <span>Online Classes</span>
                    <h2>Online Classes</h2>
                </div>
                <div class="zt-course-content-3">
                    <div class="row">
                        @foreach ($successfulOrders as $order)
                            @foreach ($order->schedule as $schedule)
                                <div class="col-lg-6 mb-4">
                                    <div class="card p-3 border-radius-md course-card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $schedule->course->name }}</h5>
                                            <div class="batch-date mb-2">
                                                <i class="fas fa-calendar icon"></i>
                                                {{ $schedule->start_date }} ({{ $schedule->duration }}
                                                {{ Str::plural($schedule->duration_type, $schedule->duration) }})
                                            </div>
                                            <div class="batch-time mb-2">
                                                <i class="fas fa-clock icon"></i>
                                                {{ $schedule->time }} to {{ $schedule->end_time }}
                                                ({{ $schedule->timezone->abbreviation }} -
                                                {{ $schedule->timezone->offset }})
                                            </div>
                                            <p class="card-text mb-1">Meeting Link:
                                                <a href="{{ $schedule->zoom_meeting_url }}" class="meeting-link">Click
                                                    here</a>
                                            </p>
                                            <p class="card-text mb-1">Meeting ID: {{ $schedule->meeting_id }}</p>
                                            <p class="card-text mb-1">Meeting Password:
                                                {{ $schedule->meeting_password }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
