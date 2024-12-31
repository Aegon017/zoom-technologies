<?php

namespace App\View\Components;

use App\Models\Blog;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsDetails extends Component
{
    public $news;

    public $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
        $this->news = Blog::where('slug', $slug)->first();
    }

    public function render(): View|Closure|string
    {
        return view('components.news-details');
    }
}
