@php
    $coursesToDisplay = isset($course) ? [$course] : $packageCourses;
@endphp

@foreach ($coursesToDisplay as $course)
    @if ($packageCourses != null)
        <h6 class="p-3 mt-3">{{ $course->name }}</h6>
    @endif
    <div class="row m-0 batch-list">
        @foreach ($course->schedule as $schedule)
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                <div class="course-batch">
                    <div class="course-batch-date">
                        <i class="fa fa-calendar"></i>
                        <p>{{ \Carbon\Carbon::parse($schedule->start_date)->format('jS M Y') }}
                        </p>
                    </div>
                    <div class="course-batch-time">
                        <i class="fa fa-clock"></i>
                        <p>{{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }} to
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                        </p>
                        <p>(IST - GMT +5.30)</p>
                    </div>
                    <div class="course-batch-duration">
                        <i class="fa fa-calendar"></i>
                        <p class="days">{{ $schedule->duration }}
                            {{ $schedule->duration_type }}</p>
                        <p class="hrs">
                            {{ (new DateTime($schedule->time))->diff(new DateTime($schedule->end_time))->h + (new DateTime($schedule->time))->diff(new DateTime($schedule->end_time))->i / 60 }}
                            Hrs/Day
                        </p>
                        <p class="m-0">
                            @foreach ($schedule->day_off as $day_off)
                                {{ $day_off }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                            off
                        </p>
                    </div>
                    <div class="course-batch-duration">
                        <i class="fa fa-clipboard"></i>
                        <p class="o-mode">
                            {{ $schedule->training_mode }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
