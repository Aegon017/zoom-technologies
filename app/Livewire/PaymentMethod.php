<?php

namespace App\Livewire;

use App\Models\PaymentGateway;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        $user = Auth::user();
        $scheduleIds = Session::get('scheduleIDs');
        $hasClassroomTraining = Schedule::whereIn('id', $scheduleIds)
            ->where('training_mode', 'Classroom')
            ->exists();
        if ($user) {
            if (!$user->studentProfile && $hasClassroomTraining) {
                $this->dispatch('show-upload-profile');
            }
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
