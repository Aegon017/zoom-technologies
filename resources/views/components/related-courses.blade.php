<div class="related-courses d-block position-relative overflow-hidden bg-white">
    <div class="container">
        <h3 class="title">Course Offered</h3>
        <div class="zt-course-content-3">
            <div class="owl-carousel" id="zt-department-slider-id">
                @foreach ($items as $item)
                    <div class="zt-popular-course-img-text">
                        <div class="zt-popular-course-img text-center">
                            <a href="{{ isset($item->slug) ? route('render.course', $item->slug) : '#' }}">
                                <img src="{{ asset(Storage::url($item->thumbnail)) }}" alt="{{ $item->thumbnail_alt }}">
                            </a>
                        </div>
                        <div class="zt-popular-course-text">
                            <div class="popular-course-title zt-headline">
                                <h3>
                                    <a href="{{ isset($item->slug) ? route('render.course', $item->slug) : '#' }}">
                                        {{ $item->name }}
                                    </a>
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
                                        {{ Str::plural($item->duration_type, $item->duration) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
