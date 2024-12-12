<?php

namespace App\Livewire;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class OtpVerification extends Component
{
    public $otp = '';

    public $otp0 = '';

    public $otp1 = '';

    public $otp2 = '';

    public $otp3 = '';

    public $otp4 = '';

    public $otp5 = '';

    public function generateOTP()
    {
        $this->otp = rand(100000, 999999);
        $user = Auth::user();
        Mail::to($user->email)->send(new OtpMail($this->otp));
        $this->dispatch('notify', message: 'OTP sent successfully');
    }

    public function verifyOTP()
    {
        $otp = $this->otp0.$this->otp1.$this->otp2.$this->otp3.$this->otp4.$this->otp5;
        $user = User::find(Auth::id());
        if ($this->otp == $otp) {
            $user->email_verified_at = now();
            $user->save();
            $this->dispatch('notify', message: 'OTP Verified');
            $this->dispatch('reload-page');
        } else {
            $this->dispatch('notify', message: 'Incorect OTP');
        }
    }

    public function resendOTP()
    {
        $this->generateOTP();
    }

    public function render()
    {
        return view('livewire.otp-verification');
    }
}
