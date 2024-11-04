<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/bn-bg1.jpg';
        $pageTitle = 'Courses';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <x-featured-courses />
</x-frontend-layout>
