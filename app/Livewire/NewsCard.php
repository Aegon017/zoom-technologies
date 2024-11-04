<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;

class NewsCard extends Component
{
    public $news = [];

    protected $listeners = ['news-lists' => 'updateNewsList'];

    public function updateNewsList($results)
    {
        $this->news = $results;
    }

    public function render()
    {
        return view('livewire.news-card', [
            'news' => $this->news,
        ]);
    }
}
