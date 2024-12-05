<x-frontend-layout>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Payment Success';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    <section id="thank-you-section" class="thank-you-section course-page-course-section text-center" class="mb-0 py-5">
        <div class="container">
            <h1 class="zt-headline">{{ $thankyou->title }}</h1>
            <h5 class="text-success">Payment Success</h5>
            <p class="pt-2"><strong>Order No. : {{ $order->order_number }}</strong></p>
            <p><strong>Payment Id : {{ $order?->payment?->payment_id }}</strong></p>
            <div style="font-size: 1.2em; margin-top: 15px;">
                {!! $thankyou->content !!}
            </div>
            <h2 class="text-orange mt-3">{{ $thankyou->heading }}</h2>
            <p class="mt-1">{{ $thankyou->sub_heading }}<br>
                <i class="fas fa-envelope"></i> <strong>Email:</strong>
                @foreach ($thankyou->email as $email)
                    @php
                        $mail = App\Models\Email::find($email)->email;
                    @endphp
                    <a href="mailto:{{ $mail }}" style="color: #007bff;">{{ $mail }}</a>
                @endforeach
                <br>
                <i class="fas fa-mobile-alt"></i> <strong>Phone:</strong>
                @foreach ($thankyou->mobile as $mobile)
                    @php
                        $number = App\Models\MobileNumber::find($mobile)->number;
                    @endphp
                    <a href="tel:{{ $number }}" style="color: #007bff;">{{ $number }}</a>
                @endforeach
            </p>
            <div style="margin-top: 40px;">
                <a href="{{ route('render.home') }}" class="btn continue-btn px-4 mr-3">Return to Home</a>
                <a href="{{ route('render.course.list') }}" class="btn btn-dark border-rounded px-4 ml-3">View Other
                    Courses</a>
            </div>
        </div>
    </section>
    <x-related-courses />
</x-frontend-layout>
