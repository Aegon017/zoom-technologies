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
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Testimonials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper testimonials-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="zt-testimonial-item" style="height: auto;">
                        <div class="user-info">
                            <h3 class="name">Yemi</h3>
                            <h5 class="designation">Nigeria</h5>
                        </div>
                        <div class="inner-content-wrapper">
                            <div class="user-review" style="max-height: 100px;">
                                <p>“This place was recommended by many in my country. Yet, I came here and personally
                                    checked this place and liked it. They are very organized here at ZOOM Technologies
                                    and
                                    everything a student needs is there. Communication skills of trainers are good which
                                    is
                                    an essential pre-requisite for teaching. If the communication isn't good, then it
                                    becomes very challenging for students to learn.”</p>
                            </div><span>…</span>
                            <span class="button">Read more<i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="zt-testimonial-item">
                        <div class="user-info">
                            <h3 class="name">Garry Bridgwater CMIOSH</h3>
                            <h5 class="designation">AIEMA Northern Regional HS & E Advisor Cable & Wireless Worldwide
                            </h5>
                        </div>
                        <div class="inner-content-wrapper">
                            <div class="user-review">
                                <p>I was recently asked by a colleague to recommend an organisation to assist with
                                    engineering activities in India, without hesitation I offered Zoom Technologies to
                                    complete the task.</p>
                                <p>My journey with Zoom family started approximately 10 years ago and I have never
                                    looked
                                    back since. As a foreign student looking to gain further education and experience as
                                    a
                                    networking engineer there was only one place I wanted to obtain the training, that
                                    being
                                    India. I had completed several courses within the UK all of which were very
                                    deliberate,
                                    soulless, over-priced. And whilst the facilitators were able to offer advice and
                                    guidance, there was always a feeling of being a clinically strict environment.</p>
                                <p>Zoom Technologies in contrast was very different, right from the initial online
                                    enquiries
                                    they made me feel welcome, wanted and accommodating all my needs, including
                                    arranging
                                    local visa information, hotels & airport transfers all of which for student
                                    attending
                                    from outside of the country was a great help. As for the training I couldn't have
                                    asked
                                    for better, the facilitators are the best within their field all of which have many
                                    years of practical working experience with large global organisations. The labs were
                                    excellent well laid out and plenty of opportunity to apply theoretical learning with
                                    the
                                    physical application, which is a significant boost incorporating top of the range
                                    equipment. Whenever I was unsure on any aspect of the instruction, the facilitators
                                    where more than accommodating with extra tuition in order ensure I fully understood.
                                </p>
                                <p>My time with Zoom family helped me obtain my Cisco (CCNP) & Microsoft (MCSE)
                                    accreditations which was hard work, but very well worth it. Not only did Zoom
                                    Technologies assist me to obtain accreditations, but also helped get an initial
                                    engineering position and to this day I am very grateful, I am now working for a
                                    global
                                    telecommunications company as a regional manager covering Asia. I regard all at Zoom
                                    Technologies as true friends and regularly keep in touch and will remain doing so.
                                </p>
                                <p>Would I recommend Zoom Technologies? most definitely, a superb and professional
                                    organisation without doubt.</p>
                            </div>
                            <span class="button">Read more<i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="zt-testimonial-item">
                        <div class="user-info">
                            <h3 class="name">M.Venkat</h3>
                            <h5 class="designation">IT Analyst, TCS</h5>
                        </div>
                        <div class="inner-content-wrapper">
                            <div class="user-review">
                                <p>My experience with Zoom was really great..unforgettable.It has shaped my career and
                                    even
                                    my life in many ways. It has brought out untapped potential in me. Zoom is
                                    undoubtedly
                                    the best place to launch your career.</p>
                            </div>
                            <span class="button">Read more<i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="zt-testimonial-item">
                        <div class="user-info">
                            <h3 class="name">Goutham Kondapavuluru</h3>
                            <h5 class="designation">Software Engineer, Cisco Systems</h5>
                        </div>
                        <div class="inner-content-wrapper">
                            <div class="user-review">
                                <p>Zoom has taught me all the nuances of networking and helped me build my career. I can
                                    proudly say that Zoom must be credited for what I have achieved today. What I
                                    learned in
                                    zoom has laid a strong foundation for my career.</p>
                            </div>
                            <span class="button">Read more<i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="zt-testimonial-item">
                        <div class="user-info">
                            <h3 class="name">Supraja Keerthipati</h3>
                            <h5 class="designation">Assistant Consultant, TCS</h5>
                        </div>
                        <div class="inner-content-wrapper">
                            <div class="user-review">
                                <p>I am very happy to say that the training offered in Zoom Technologies added great
                                    value
                                    to improve my technical skills. During the training period, I found that faculties
                                    have
                                    expertise in domain knowledge and shared their real-time experiences with live
                                    examples
                                    which helped me get hands-on experience. Zookm has state-of-the-art lab facilities.
                                    And
                                    my training with Zoom is what helped me to get opportunity to work in one of the IT
                                    giants in India: Tata Consultancy Services.</p>
                            </div>
                            <span class="button">Read more<i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
