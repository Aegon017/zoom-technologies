<?php

namespace App\Livewire;

use App\Models\PaymentGateway;
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

    public $paymentGateways;

    public function mount()
    {
        $this->paymentGateways = PaymentGateway::first()?->gateway;
    }

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
            $this->dispatch('show-address-form');
            $this->dispatch('show-otp-verification');
        } else {
            $this->dispatch('show-login-form');
        }
    }

    public function render()
    {
        return view('livewire.payment-method');
    }
}
