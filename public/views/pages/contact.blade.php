<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Contact Us';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-wrapper">
                        <div class="row p-0 m-0">
                            <x-contact-card />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
