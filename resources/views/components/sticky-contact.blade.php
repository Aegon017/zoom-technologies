<div class="sticky-bottom-contact-section active">
    <ul>
        <li><strong>Contact Our Course Advisor</strong></li>
        @foreach ($stickyContact->mobile as $mobile)
            @php
                $number = App\Models\MobileNumber::find($mobile)->number;
            @endphp
            <li><i class="fa fa-phone"></i><a href="tel:{{ $number }}">{{ $number }}</a></li>
        @endforeach
        @foreach ($stickyContact->email as $email)
            @php
                $mail = App\Models\Email::find($email)->email;
            @endphp
            <li><i class="fa fa-envelope"></i><a href="mailto:{{ $mail }}">{{ $mail }}</a></li>
        @endforeach
    </ul>
</div>
