@foreach ($upcomingSchedules as $schedule)
    @php
        $item = $schedule['item'];
        $latestSchedule = $schedule['latest_schedule'];
        $timeZone = $schedule['latest_schedule']->timezone;
        $timings = $schedule['timings'];
    @endphp
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
        <div class="upcoming-batch-card">
            <div class="upcoming-batch-top">
                <a href="training/india/cybersecurity-offer">
                    <h3 class="course-title">
                        {{ $item->name }}
                    </h3>
                </a>
                <ul class="course-tags">
                    <li>
                        @foreach ($item->training_mode as $mode)
                            {{ $mode }}@if (!$loop->last)
                                /
                            @endif
                        @endforeach
                    </li>
                </ul>
                <div class="batch-date">
                    <i class="fas fa-calendar"></i>
                    @if ($latestSchedule)
                        {{ $latestSchedule->start_date }}
                    @else
                        No upcoming date
                    @endif
                </div>
                <div class="batch-time d-block">
                    @if ($timings)
                        @foreach ($timings as $timing)
                            <i class="fas fa-clock"></i>
                            {{ $timing->time }} to {{ $timing->end_time }} ({{ $timing->timeZone->abbreviation }} -
                            {{ $timing->timeZone->offset }})
                        @endforeach
                    @else
                        <i class="fas fa-clock"></i>
                        No upcoming time
                    @endif
                </div>
            </div>
            <div class="upcoming-batch-bottom">
                <p class="batch-duration">
                    {{ $item->duration }} {{ $item->duration_type }}
                </p>
                <a href="{{ route('render.course', $item->slug) }}" class="btn-batch-details">Know More<i
                        class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
    </div>
@endforeach
