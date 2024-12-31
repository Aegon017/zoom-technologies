<?php

namespace App\Livewire;

use App\Models\BlogCategory;
use Livewire\Component;

class NewsCategory extends Component
{
    public $newsCategories;

    public function mount()
    {
        $this->newsCategories = BlogCategory::all();
    }

    public function render()
    {
        return view('livewire.news-category');
    }
}
