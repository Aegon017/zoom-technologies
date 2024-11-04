<div class="col-xl-6 wow fadeInLeft" data-wow-delay="100ms">
    <div class="news-one__single bg-white">
        <div class="news-one__img-box">
            <div class="news-one__img">
                <img src="{{ asset(Storage::url($newsItem->thumbnail)) }}" alt="{{ $newsItem->thumbnail_alt }}">
            </div>
        </div>
        <div class="news-one__content">
            <div class="news-one__content-top">
                <h3 class="news-one__title">
                    <a href="{{ route('render.news', $newsItem->slug) }}">{{ $newsItem->name }}</a>
                </h3>
                <div class="news-one__text">{!! $newsItem->content !!}</div>
            </div>
            <div class="news-one__person-and-date">
                <div class="news-one__person">
                    <div class="news-one__person-text">
                        <p></p>
                    </div>
                </div>
                <div class="news-one__date">
                    <p><span
                            class="fas fa-calendar"></span>{{ \Carbon\Carbon::parse($newsItem->created_at)->format('F j, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
