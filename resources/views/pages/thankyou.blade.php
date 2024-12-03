<x-frontend-layout>
    <section id="thank-you-section" class="thank-you-section text-center" style="padding: 100px 0;">
        <div class="container">
            <h1 class="zt-headline">{{ $thankyou->title }}</h1>
            <div style="font-size: 1.2em; margin-top: 20px;">
                {!! $thankyou->content !!}
            </div>
            <h2 style="margin-top: 20px;">{{ $thankyou->heading }}</h2>
            <p style="margin-top: 10px;">{{ $thankyou->sub_heading }}<br>
                📧 <strong>Email:</strong>
                @foreach ($thankyou->email as $email)
                    @php
                        $mail = App\Models\Email::find($email)->email;
                    @endphp
                    <a href="mailto:{{ $mail }}" style="color: #007bff;">{{ $mail }}</a>
                @endforeach
                <br>
                📞 <strong>Phone:</strong>
                @foreach ($thankyou->mobile as $mobile)
                    @php
                        $number = App\Models\MobileNumber::find($mobile)->number;
                    @endphp
                    <a href="tel:{{ $number }}" style="color: #007bff;">{{ $number }}</a>
                @endforeach
            </p>
            <div style="margin-top: 40px;">
                <a href="https://www.zoomgroup.com/" class="btn btn-primary">Return to Home</a>
                <a href="https://www.zoomgroup.com/training/india/courses" class="btn btn-secondary">View Other
                    Courses</a>
            </div>
        </div>
    </section>
</x-frontend-layout>
