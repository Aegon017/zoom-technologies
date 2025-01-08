<x-frontend-layout>
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
                                @if ($schedule->status == true && $schedule->training_mode == 'Online')
                                    <div class="col-lg-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $schedule->course->name }}</h5>
                                                <p class="card-text">Meeting Link: <a
                                                        href="{{ $schedule->zoom_meeting_url }}">Click here</a></p>
                                                <p class="card-text">Meeting Id: {{ $schedule->meeting_id }}</p>
                                                <p class="card-text">Meeting Password: {{ $schedule->meeting_password }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
    </section>
</x-frontend-layout>
