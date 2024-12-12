<?php

namespace App\Livewire;

use Livewire\Component;

class PaymentMethod extends Component
{
    public $name;
    public $payablePrice;
    public $productType;
    public function render()
    {
        return view('livewire.payment-method');
    }
}
