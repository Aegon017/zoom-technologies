<?php

namespace App\View\Components;

use App\Models\NewsCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsCategories extends Component
{
    public $newsCategory;

    public function __construct()
    {
        $this->newsCategory = NewsCategory::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.news-categories');
    }
}
