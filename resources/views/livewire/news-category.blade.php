<div class="sidebar__single sidebar__category">
    <div class="sidebar__title-box">
        <h3 class="sidebar__title">Categories</h3>
    </div>
    <ul class="sidebar__category-list list-unstyled">
        <li>
            <a href="{{ route('render.news.list') }}">All</a>
        </li>
        @foreach ($newsCategories as $category)
            <li>
                <a href="{{ route('news.category', $category->name) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>