<section id="course-page-course" class="course-page-course-section">
    <div class="container">
        @if ($subscription == 'free')
            @php
                $studyMaterials = $courseStudyMaterials->concat($otherStudyMaterials);
            @endphp
            <div class="course-page-course-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <p class="title-watermark">Study Materials</p>
                    <span>Study Materials</span>
                    <h2>Study Materials</h2>
                </div>
                <div class="zt-course-content-3">
                    <div class="row">
                        @foreach ($studyMaterials as $material)
                            <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 mb-4">
                                <div class="study-material-item">
                                    <a href="{{ $material->material_pdf ? asset(Storage::url($material->material_pdf)) : $material->material_url }}"
                                        target="{{ $material->material_pdf ? '_blank' : '_self' }}">
                                        <img src="{{ asset(Storage::url($material->image)) }}"
                                            alt="{{ $material->image_alt }}">
                                        <div class="study-material-content">
                                            <h3>{{ $material->name }}</h3>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            @php
                $items = $courses->concat($packages)->sortBy('position');
            @endphp
            <div class="course-page-course-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <p class="title-watermark">Study Materials</p>
                    <span>Study Materials</span>
                    <h2>Course Study Materials</h2>
                </div>
                <div class="zt-course-content-3">
                    <div class="row">
                        @foreach ($items as $item)
                            @if ($item)
                                <div class="col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="0ms"
                                    data-wow-duration="1500ms">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
</section>
