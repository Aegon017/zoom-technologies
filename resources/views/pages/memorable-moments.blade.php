<x-frontend-layout>
    @if ($metaDetail != null)
        <x-slot:metaTitle>
            {{ $metaDetail->title }}
        </x-slot>
        <x-slot:metaKeywords>
            {{ $metaDetail->keywords }}
        </x-slot>
        <x-slot:metaDescription>
            {{ $metaDetail->description }}
        </x-slot>
    @endif

    @if ($pageSchema != null)
        <x-slot:localSchema>
            {!! $pageSchema->local_schema !!}
        </x-slot>
        <x-slot:organizationSchema>
            {!! $pageSchema->organization_schema !!}
        </x-slot>
    @endif
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Memorable Moments';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper memorable-moments-page">
        <div class="container">
            <div class="masonry-grid">
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/zoom-surat-launch-1.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/zoom-surat-launch-1.jpg') }}"
                                alt="Zoom Surat launch event with audience view.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Sri Purnesh Modi, BJP MLA Surat, cutting the ribbon in the presence of Sri Atul Shah and Mr.
                            MH Noble</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/zoom-surat-launch-2.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/zoom-surat-launch-2.jpg') }}"
                                alt="Zoom Surat launch event, audience and dignitaries at the event.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Mr. MH Noble, CEO, Zoom Technologies, giving a tour of the state of the art lab to Sri
                            Purnesh Modi and Sri Atul Shah</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/zoom-vijaywada-launch3.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/zoom-vijaywada-launch3.jpg') }}"
                                alt="Zoom Vijayawada launch event with crowd interaction.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Sri Palle Raghunatha Reddy, Hon'ble Minister for IT , Andhra Pradesh , inaugurating the Zoom
                            Center for Excellence in Vijayawada</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/zoom-vijaywada-launch1.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/zoom-vijaywada-launch1.jpg') }}"
                                alt="Zoom Vijayawada launch event, ribbon cutting ceremony.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Mr. Noble, Managing Director, Zoom Technologies, announcing the launch of the Center of
                            Excellence at Vijaywada.</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/zoom-vijaywada-launch2.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/zoom-vijaywada-launch2.jpg') }}"
                                alt="Zoom Vijayawada launch event, crowd gathering view.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Sri. Palle Raghunatha Reddy, Hon'ble Minister for IT, Andhra Pradesh, accompanied by Mr.
                            Noble, examining the state of the art network equipment rack.</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/rosaiah.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/rosaiah.jpg') }}"
                                alt="Image of politician Rosaiah at a Zoom Group event.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Mr. M.H. Noble with Former Chief Minister of A.P., Sri. K. Rosaiah Garu</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/chiefminister-visit.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/chiefminister-visit.jpg') }}"
                                alt="Image of a Chief Minister visit to Zoom Group event.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Former Chief Minister Late Dr. Y. S. Rajashekar Reddy and former Chief Minister of Madhya
                            Pradesh Sri Digvijay Singh with Mr. M.H. Noble at the inauguration of Data Centre,
                            Gollapudi, Vijayawada on 9th August, 2004.</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/ysrao-reddy.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/ysrao-reddy.jpg') }}"
                                alt="Image of politician YS Rao Reddy attending a Zoom event.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Former Chief Minister of A.P., Late Dr. Y.S. Rajashekar Reddy, Mr. M.H. Noble at Anti Virus
                            Launch in India in 2006.</p>
                    </div>
                </div>
                <div class="grid-item image-text-card">
                    <div class="img">
                        <a class="zt-photo-popup" data-lightbox="mmoments"
                            href="{{ asset('frontend/assets/img/memorable-moments/ysrao-reddy2.jpg') }}">
                            <img src="{{ asset('frontend/assets/img/memorable-moments/ysrao-reddy2.jpg') }}"
                                alt="YS Rao Reddy at a Zoom Group event, second view.">
                        </a>
                    </div>
                    <div class="content">
                        <p>Mr. M. H. Noble in conversation with the Former Chief Minister of A.P., Late Dr. Y.S.
                            Rajashekar Reddy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
