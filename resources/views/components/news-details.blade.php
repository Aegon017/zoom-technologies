<div class="news-details__left">
    <h3 class="news-details__title-1">{{ $news->name }}</h3>
    <div class="news-details__author-and-meta">
        <div class="news-details__author">
        </div>
        <div class="news-details__meta">
            <p><span class="fas fa-calendar"></span>{{ \Carbon\Carbon::parse($news->created_at)->format('F j, Y') }}
            </p>
            <p><span class="fa fa-bookmark ">&nbsp;Source :</span> <a href="#">{{ $news->source }}</a></p>
            <p>
                <a href="new/"><i class="fas fa-tag "></i> {{ $news->blogCategory->name }}</a>
            </p>
        </div>
    </div>
    <div>
        <img src="{{ asset(Storage::url($news->image)) }}" alt="{{ $news->image_alt }}" width="100%">
    </div>
    <div class="news-details__text-1">{!! $news->content !!}</div>
    <div class="news-details__tag-and-social">
        <div class="news-details__social">
            <span>Share on:</span>
            <a href="https://www.facebook.com/sharer/sharer?u=news/{{ $news->slug }}" target="_blank"><i
                    class="fab fa-facebook"></i></a>
        </div>
    </div>
</div>
