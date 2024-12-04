@php
    $items = $courses;
@endphp
<section id="course-page-course" class="course-page-course-section">
    <div class="container">
        <div class="course-page-course-content">
            <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                <p class="title-watermark">Courses</p>
                <span>Courses</span>
                <h2>My Courses</h2>
            </div>
            <div class="zt-course-content-3">
                <div class="row">
                    @foreach ($items as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="zt-popular-course-img-text">
                                <div class="zt-popular-course-img text-center">
                                    <a href="{{ route('render.myCourse', $item->slug) }}">
                                        <img src="{{ asset(Storage::url($item->thumbnail)) }}"
                                            alt="{{ $item->thumbnail_alt }}">
                                    </a>
                                </div>
                                <div class="zt-popular-course-text">
                                    <div class="popular-course-title zt-headline">
                                        <h3><a
                                                href="{{ route('render.myCourse', $item->slug) }}">{{ $item->name }}</a>
                                        </h3>
                                        <div class="zt-course-meta">
                                            <a><i class="fas fa-file"></i>
                                                @foreach ($item->training_mode as $mode)
                                                    {{ $mode }}@if (!$loop->last)
                                                        /
                                                    @endif
                                                @endforeach
                                            </a>
                                            <a><i class="fas fa-calendar"></i>{{ $item->duration }}
                                                {{ $item->duration_type }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
</section>
