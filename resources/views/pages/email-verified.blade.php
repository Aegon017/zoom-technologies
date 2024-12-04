<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Checkout';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <div class="email-verified-section py-5">
        <div class="container">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1>Email Verified Successfully!</h1>
                    <p>Your email address has been verified. You can now access all features of your account.</p>
                    <a href="{{ route('render.myOrders') }}" class="btn continue-btn">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
