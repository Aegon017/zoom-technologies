<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Your Study Materials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper e-books-page">
        <div class="container">
            <div class="e-books-wrapper bg-white d-block w-100 p-4 mb-4">
                <div class="e-books-content d-block mb-4 position-relative text-center">
                    <h3 class="text-primary text-center mb-4">Your courses</h3>
                </div>
                <div class="zt-ebooks-list d-block w-100 position-relative">
                    <div class="row">
                        <x-student-courses />
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
