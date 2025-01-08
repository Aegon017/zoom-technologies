<x-frontend-layout>
    <style>
        .border-radius-md {
            border-radius: 1rem;
        }

        .course-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .course-card .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .course-card .card-text {
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
                                @if ($schedule->status && $schedule->training_mode === 'Online')
                                    <div class="col-lg-6 mb-4">
                                        <div class="card p-3 border-radius-md course-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $schedule->course->name }}</h5>
                                                <div class="batch-date mb-2">
                                                    <i class="fas fa-calendar text-primary"></i>
                                                    {{ $schedule->start_date }}
                                                </div>
                                                <div class="batch-time mb-2">
                                                    <i class="fas fa-clock text-primary"></i>
                                                    {{ $schedule->time }} to {{ $schedule->end_time }}
                                                    ({{ $schedule->timezone->abbreviation }} -
                                                    {{ $schedule->timezone->offset }})
                                                </div>
                                                <p class="card-text mb-1">{{ $schedule->duration }}
                                                    {{ Str::plural($schedule->duration_type, $schedule->duration) }}</p>
                                                @php
                                                    $timeDiff = (new DateTime($schedule->time))->diff(
                                                        new DateTime($schedule->end_time),
                                                    );
                                                    $hoursPerDay = $timeDiff->h + $timeDiff->i / 60;
                                                @endphp
                                                <p class="card-text mb-1">{{ number_format($hoursPerDay, 2) }} Hrs/Day
                                                </p>
                                                <p class="card-text mb-1">{{ implode(', ', $schedule->day_off) }} off
                                                </p>
                                                <p class="card-text mb-1">Meeting Link:
                                                    <a href="{{ $schedule->zoom_meeting_url }}"
                                                        class="text-primary">Click here</a>
                                                </p>
                                                <p class="card-text mb-1">Meeting ID: {{ $schedule->meeting_id }}</p>
                                                <p class="card-text mb-1">Meeting Password:
                                                    {{ $schedule->meeting_password }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
