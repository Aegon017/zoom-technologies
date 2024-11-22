<?php

namespace App\View\Components\Partials;

use App\Models\FooterSection;
use App\Models\MobileNumber;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $footer;
    public function __construct()
    {
        return $this->footer = FooterSection::first();
    }

    public function render(): View|Closure|string
    {
        return view('components.partials.footer');
    }
}
