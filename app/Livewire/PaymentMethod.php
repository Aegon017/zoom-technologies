<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PaymentMethod extends Component
{
    public $name;

    public $payablePrice;

    public $productType;

    public $bankTransferDetails;

    public $qrCode;

    #[On('check-address')]
    public function checkAddress()
    {
        if (Auth::user()?->addresses) {
            $this->dispatch('show-pay-button');
        }
    }

    public function checkAuth()
    {
        if (Auth::check()) {
            if (Auth::user()?->email_verified_at) {
                $this->dispatch('show-address-form');
            } else {
                $this->dispatch('show-otp-verification');
            }
        } else {
            $this->dispatch('show-login-form');
        }
    }

    public function render()
    {
        return view('livewire.payment-method');
    }
}
