@foreach ($locations as $location)
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-3">
        <div class="zt-contact-box">
            <div class="tag">{{ $location->location_type }}</div>
            <div class="map">
                {!! $location->map_iframe !!}
            </div>
            <div class="contact-info">
                <h3 class="city">{{ $location->city }}</h3>
                <p class="address">{{ $location->address }}</p>
                <ul>
                    @php
                        $mobileNumbers = explode(',', $location->mobile);
                        $landlineNumbers = explode(',', $location->landline);
                    @endphp

                    @if (!empty($landlineNumbers[0]))
                        <li>
                            <i class="fas fa-phone-volume"></i>
                            <span class="text">
                                @foreach ($landlineNumbers as $number)
                                    <a href="tel:{{ $number }}">+91 - {{ $number }}</a>
                                    @if (!$loop->last)
                                        <span class="divider">/</span>
                                    @endif
                                @endforeach
                            </span>
                        </li>
                    @endif

                    <li>
                        <i class="fas fa-mobile"></i>
                        <span class="text">
                            @foreach ($mobileNumbers as $number)
                                <a href="tel:+91{{ $number }}">+91 - {{ $number }}</a>
                                @if (!$loop->last)
                                    <span class="divider">/</span>
                                @endif
                            @endforeach
                        </span>
                    </li>

                    @if (!empty($location->email))
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span class="text"><a
                                    href="mailto:{{ $location->email }}">{{ $location->email }}</a></span>
                        </li>
                    @endif

                    @if (!empty($location->website))
                        <li>
                            <i class="fas fa-globe"></i>
                            <span class="text"><a href="https://{{ $location->website }}"
                                    target="_blank">{{ $location->website }}</a></span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endforeach
