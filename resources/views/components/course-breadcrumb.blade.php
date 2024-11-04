<div class="zt-breadcrumb-default zt-breadcrumb-style-3">
    <div class="breadcrumb-inner">
        <img src="{{ asset(Storage::url($course->image ?? $package->image)) }}" alt="{{$course->image_alt ?? $package->image_alt}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content text-start">
                        <ul class="page-list">
                            <li class="zt-breadcrumb-item"><a href="">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="fa fa-angle-right"></i></div>
                            </li>
                            <li class="zt-breadcrumb-item active">Course</li>
                        </ul>
                        <h2 class="title">
                            {!! isset($course)
                                ? $course->name
                                : ($package->overview->uscouncil_certified
                                    ? '<img src="' .
                                        asset('frontend/assets/img/us-council-white.png') .
                                        '" alt="US Council Logo"> Certified ' .
                                        $package->name .
                                        ' Course'
                                    : $package->name . ' Training') !!}
                        </h2>
                        <div class="description">{!! isset($course) ? $course->short_description : $package->short_description !!}</div>
                        <div class="d-flex align-items-center mb-3 flex-wrap zt-course-details-feature">
                            <div class="feature-sin best-seller-badge">
                                <span class="zt-badge-2">
                                    <span class="image">
                                        <img src="{{ asset('frontend/assets/img/icon/card-icon-1.png') }}"
                                            alt="Best Seller Icon">
                                    </span>
                                    Bestseller
                                </span>
                            </div>
                            <div class="feature-sin rating">
                                <a href="#">4.8</a>
                                @for ($i = 0; $i < 5; $i++)
                                    <a href="#"><i class="fa fa-star"></i></a>
                                @endfor
                            </div>
                            <div class="feature-sin total-rating">
                                <a class="zt-badge-4" href="#">215,475 ratings</a>
                            </div>
                            <div class="feature-sin total-student">
                                <span>616,029 students</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
