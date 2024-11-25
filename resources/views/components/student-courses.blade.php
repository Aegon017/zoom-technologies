<ul>
    @foreach ($courses as $course)
        <li>
            <h6><a href="{{ route('render.myCourse', $course['courseSlug']) }}"> {{ $course['courseName'] }}</a></h6>
        </li>
    @endforeach
</ul>
