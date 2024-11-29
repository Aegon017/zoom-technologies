<?php

namespace App\Livewire;

use App\Models\NewsCategory as ModelsNewsCategory;
use Livewire\Component;

class NewsCategory extends Component
{
    public $newsCategories;

    public function mount()
    {
        $this->newsCategories = ModelsNewsCategory::all();
    }

    public function render()
    {
        return view('livewire.news-category');
    }
}
