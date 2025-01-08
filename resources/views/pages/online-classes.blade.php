<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Online Classes';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section id="course-page-course" class="course-page-course-section">
        <div class="container">
            <div class="course-page-course-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <p class="title-watermark">Online Classes</p>
                    <span>Online Classes</span>
                    <h2>Online Classes</h2>
                </div>
                <div class="zt-course-content-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Meeting Link: <a href=""> dsfsfdsf</a></p>
                                    <p class="card-text">Meeting Id: </p>
                                    <p class="card-text">Meeting Password: </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</x-frontend-layout>
