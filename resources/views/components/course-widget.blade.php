<div class="course-details-widget style-two course-sidebar sticky-top">
    <div class="course-widget-wrap">
        <div class="cd-video-widget position-relative">
            <img src="{{ asset(Storage::url($item->image)) }}" alt="{{ $item->image_alt }}">
            <a class="video_box text-center" href="https://youtu.be/naLqv5fj3T0"><i class="fas fa-play"></i></a>
            <span class="play-view-text d-block color-white"><i class="fas-fa-eye"></i>
                Preview
                this
                course</span>
        </div>
    </div>
    <div class="course-widget-wrap">
        <div class="cd-course-table-widget">
            <div class="cd-course-table-list">
                <div class="course-table-item clearfix">
                    <span class="cd-table-title float-left"><i class="fas fa-clock"></i>
                        Duration
                        :
                    </span>
                    <span class="cd-table-valur float-right">{{ $item->duration }}
                        {{ $item->duration_type }}</span>
                </div>
                <div class="course-table-item clearfix">
                    <span class="cd-table-title float-left"><i class="fas fa-laptop"></i>
                        Mode
                        Of
                        Training :
                    </span>
                    <span class="cd-table-valur float-right">
                        @foreach ($item->training_mode as $mode)
                            {{ $mode }}@if (!$loop->last)
                                /
                            @endif
                        @endforeach
                    </span>
                </div>
                <div class="course-table-item clearfix">
                    <span class="cd-table-title float-left"><i class="fas fa-briefcase"></i>
                        Placement Assistance :
                    </span>
                    <span class="cd-table-valur float-right">{{ $item->placement ? 'Yes' : 'No' }}</span>
                </div>
                <div class="course-table-item clearfix">
                    <span class="cd-table-title float-left"><i class="fas fa-paste"></i>
                        Certificate :
                    </span>
                    <span class="cd-table-valur float-right">{{ $item->certificate ? 'Yes' : 'No' }}</span>
                </div>
                @if ($item->original_price)
                    <div class="course-table-item clearfix text-center mb-1">
                        <p class="mb-0"><strong class="txt-primary">Introductory Limited Period Offer</strong></p>
                        <h4 class="txt-primary m-0"><del class="txt-priamry">INR {{ number_format($item->price) }}</del>
                        </h4>
                    </div>
                @endif
            </div>
            <div class="cd-course-price clearfix">
                @php
                    $price = $item->original_price ? $item->original_price : $item->price;
                    $sgst = $price * 0.09;
                    $cgst = $price * 0.09;
                    $total_price = $price + $sgst + $cgst;
                @endphp
                <span>Price: <strong><i
                            class="fas fa-rupee-sign"></i>{{ $item->original_price ? number_format($item->original_price) : number_format($item->price) }}</strong></span>
                <div class="payment-button">
                    <button data-toggle="modal" data-target="#checkoutpopup">Buy
                        Now</button>
                </div>
            </div>
            <div class="note-box">
                <p class="txt-primary">All prices are subject to an 18% Goods and Service
                    Tax
                    (GST) Charge. Rate quoted in U.S. dollars subject to change according to
                    Foreign Exchange rates.</p>
                <p>Once you make the payment, kindly contact our course counsellor at <a
                        href="mailto:priya@zoomgroup.com">priya@zoomgroup.com</a> to
                    schedule
                    the course as per your convenience from the available slots.</p>
            </div>
        </div>
    </div>
</div>
