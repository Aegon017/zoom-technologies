<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/bn-bg1.jpg';
        $pageTitle = 'Upcoming Batches';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section id="upcoming-batch-page" class="upcoming-batch-page-section">
        <div class="container">
            <div class="upcoming-batch-page-content">
                <div class="zt-section-title text-center zt-headline zt-title-style-two position-relative">
                    <span>Zoom Technologies</span>
                    <h2>Upcoming Batches.</h2>
                </div>
                <div class="upcoming-batch-grid-list">
                    <div class="row">
                        <x-upcoming-batches-card :$latestSchedules />
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
