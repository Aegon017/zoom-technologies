@if ($stickyContact)
    <div class="sticky-bottom-contact-section active">
        <ul>
            <li><strong>Contact Our Course Advisor</strong></li>
            <li>
                <i class="fa fa-phone"></i><a
                    href="tel:{{ $stickyContact->mobileNumber->number }}">{{ $stickyContact->mobileNumber->number }}</a>
            </li>
            <li>
                <i class="fa fa-envelope"></i><a
                    href="mailto:{{ $stickyContact->email->email }}">{{ $stickyContact->email->email }}</a>
            </li>
        </ul>
    </div>
@endif
