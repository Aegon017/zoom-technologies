<?php

namespace App\Livewire;

use Livewire\Component;

class PromoCode extends Component
{
    public $coursePrice;
    public $sgst;
    public $cgst;
    public $payablePrice;
    public $promoCode = '';

    public function applyPromoCode()
    {
        dd($this->promoCode);
    }

    public function render()
    {
        return view('livewire.promo-code');
    }
}
