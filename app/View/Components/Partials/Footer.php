<?php

namespace App\View\Components\Partials;

use App\Models\FooterSection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $footer;
    public function __construct()
    {
        return $this->footer = FooterSection::find(1);
        dd($this->footer);
    }

    public function render(): View|Closure|string
    {
        return view('components.partials.footer');
    }
}
