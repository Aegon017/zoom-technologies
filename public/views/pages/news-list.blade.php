<x-frontend-layout>
    @php
    $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
    $pageTitle = 'News';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="news-left zt-inner-page-wrapper blog-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar sidebar--two">
                        <livewire:news-search />
                        <livewire:news-category />
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7">
                    <livewire:news-card :$news />
                </div>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>