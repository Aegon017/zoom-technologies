<?php

namespace App\View\Components;

use App\Models\StickyContact as ModelsStickyContact;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StickyContact extends Component
{
    public $stickyContact;
    public function __construct()
    {
        $this->stickyContact = ModelsStickyContact::find(1);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sticky-contact');
    }
}
