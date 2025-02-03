@php
    $startDate = $schedule->start_date;
    $startTime = $schedule->time;
    $endTime = $schedule->end_time;
    $sTime = new DateTime($schedule->time);
    $eTime = new DateTime($schedule->end_time);
    if ($eTime < $sTime) {
        $eTime->modify('+1 day');
    }
    $timeDiff = $sTime->diff($eTime);
    $hoursPerDay = $timeDiff->h + $timeDiff->i / 60;
    $daysOff = implode(', ', $schedule->day_off);
    $timeZone = $schedule->timezone;
@endphp
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
    <div class="course-batch">
        <div class="course-batch-date">
            <i class="fa fa-calendar"></i>
            <p>{{ $startDate }}</p>
        </div>
        <div class="course-batch-time">
            <i class="fa fa-clock"></i>
            <p>{{ $startTime }} to {{ $endTime }}</p>
            <p>({{ $timeZone?->abbreviation }} - {{ $timeZone?->offset }})</p>
        </div>
        <div class="course-batch-duration">
            <i class="fa fa-calendar"></i>
            <p class="days">
                {{ $schedule->duration }}
                {{ Str::plural($schedule->duration_type, $schedule->duration) }}
            </p>
            <p class="hrs">{{ $hoursPerDay }} Hrs/Day</p>
            <p class="m-0">{{ $daysOff }} off</p>
        </div>
        <div class="course-batch-duration">
            <i class="fa fa-clipboard"></i>
            <p class="o-mode">{{ $schedule->training_mode }}</p>
        </div>
    </div>
</div>
