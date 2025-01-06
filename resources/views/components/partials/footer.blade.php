@if (isset($footer) && $footer)
    <footer id="zt-footer" class="zt-footer-section-2 footer-style-2">
        <div class="container">
            <div class="zt-footer-content-wrap">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="zt-footer-widget">
                            <div class="zt-footer-logo-widget zt-headline pera-content">
                                <div class="zt-footer-logo">
                                    <a href="#"><img src="{{ asset(Storage::url($footer->logo)) }}"
                                            alt="{{ $footer->logo_alt }}"></a>
                                </div>
                                <p>{{ $footer->content }}</p>
                                <div class="zt-footer-social ul-li">
                                    <ul>
                                        @foreach ($footer->social_links as $social_link)
                                            @php
                                                $link = App\Models\SocialLink::find($social_link);
                                            @endphp
                                            <a href="{{ $link->redirect_url }}"
                                                target="_blank">{!! $link->icon !!}</a>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($footer->footerOffice as $office)
                        <div class="col-lg-3 col-md-6">
                            <div class="zt-footer-widget">
                                <div class="zt-footer-info-widget ul-li">
                                    <h3 class="widget-title">{{ $office->name }}:</h3>
                                    <ul>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <a href="{{ $office->location_url }}">{{ $office->location }}</a>
                                        </li>
                                        <li class="phone-icon-text">
                                            <i class="fas fa-phone"></i>
                                            @foreach ($office->mobile as $mobile)
                                                @php
                                                    $number = App\Models\MobileNumber::find($mobile)->number;
                                                @endphp
                                                <a class="mobile-link" href="tel:{{ $number }}"
                                                    data-full-number="{{ $number }}">{{ $number }}</a>
                                            @endforeach
                                        </li>
                                        @foreach ($office->email as $email)
                                            @php
                                                $mail = App\Models\Email::find($email)->email;
                                            @endphp
                                            <li>
                                                <i class="fas fa-envelope"></i><a
                                                    href="mailto:{{ $mail }}">{{ $mail }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-3 col-md-6">
                        <div class="zt-footer-widget">
                            <div class="zt-footer-links-widget">
                                <h3 class="widget-title">Quick Links</h3>
                                <div class="clearfix">
                                    <ul>
                                        <li><a href="#about">About Us</a></li>
                                        <li><a href="{{ route('render.contact') }}">Contact Us</a></li>
                                        <li><a href="{{ route('render.course.list') }}">Courses</a></li>
                                        <li><a href="{{ route('render.free.ebooks') }}">Study Material</a></li>
                                        <li><a href="{{ route('render.franchisee') }}">Franchisee</a></li>
                                        <li><a href="{{ route('render.memorable-moments') }}">Memorable Moments</a>
                                        </li>
                                        <li><a href="https://www.zoomcybersense.com/customers.php"
                                                target="_blank">Customers</a></li>
                                        <li><a href="{{ route('render.testimonials') }}">Testimonials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="zt-footer-copyright text-center"><span>Copyright © 1996-2025 <span class="text-uppercase"><a
                            href="#">zoom
                            Technologies india private limited</a></span>. All Rights Reserved.</span></div>
        </div>
    </footer>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.mobile-link').forEach((link, index) => {
            const fullNumber = link.getAttribute('data-full-number');
            link.textContent = index > 0 ? fullNumber.replace(/^\+91/, '') : fullNumber;
        });
    });
</script>
