<?php

namespace App\View\Components;

use App\Models\ContactLocation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContactCard extends Component
{

    public $locations;
    public function __construct()
    {
        $this->locations = ContactLocation::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.contact-card');
    }
}
