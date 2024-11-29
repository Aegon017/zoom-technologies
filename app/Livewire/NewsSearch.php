<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;

class NewsSearch extends Component
{
    public $search = '';

    public $results = [];

    public function updatedSearch($value)
    {
        $this->results = News::where('name', 'like', '%'.$value.'%')->get();
        $this->dispatch('news-lists', $this->results);
    }

    public function render()
    {
        return view('livewire.news-search');
    }
}
