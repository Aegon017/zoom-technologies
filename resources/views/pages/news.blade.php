<x-frontend-layout>
    @php
    $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
    $pageTitle = 'News';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="news-left zt-inner-page-wrapper news-details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <x-news-details :$slug />
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">
                        <livewire:news-category />
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
