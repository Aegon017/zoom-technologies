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
        $pageTitle = 'Franchisee';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section class="zt-inner-page-wrapper e-books-page">
        <div class="container">
            <div class="content-wrapper bg-white d-block w-100">
                <h3 class="zt-sub-title">About Zoom</h4>
                    <p><strong>ZOOM Technologies (India) Pvt. Ltd.</strong> is a pioneer in providing Cybersecurity and
                        Cyber Forensic solutions. Our clients are spread across the entire spectrum including defence,
                        space, banks, governments, financial institutions, universities, railways, hospitals etc.</p>
                    <p>We are leaders in the field of Cybersecurity training. Since our inception almost two decades
                        ago, we have trained over a Two hundred thousand engineers. We offer a world class learning
                        environment with the best lab infrastructure and faculty with real industry experience gained by
                        working on live projects of national importance.</p>
                    <p>We now also offer Training and Solutions on Artificial Intelligence (AI), Machine Learning (ML),
                        Internet of Things (IoT) and Embedded Systems.</p>
                    <h3 class="zt-sub-title">Become a Franchisee</h3>
                    <p>We offer various franchise opportunity and partnership models in India and Overseas (USA / Europe
                        / Middle East / Europe / Australia Etc). Please e-mail to Mr. Noble at <a
                            href="mailto:noble@zoomgroup.com">noble@zoomgroup.com</a> for more details.</p>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
