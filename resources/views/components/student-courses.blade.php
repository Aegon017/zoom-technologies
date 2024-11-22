@foreach ($courses as $course)
    <a class="dropdown-item" href="{{ route('render.myCourse', $course['courseSlug']) }}"><i class="fas fa-bookmark"></i>
        {{ $course['courseName'] }}</a>
@endforeach
