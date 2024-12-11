<?php

namespace App\Livewire;

use App\Mail\EmailVerified;
use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class OtpVerification extends Component
{
    public $otp = ['', '', '', '', '', ''];
    public $otp_sent = false;
    public $otp_expired = false;
    public $time_left = 120;
    public $resend_allowed = true;
    public $error_message = '';
    public $success_message = '';

    public function mount()
    {
        if (Auth::user() && Auth::user()->email_verified_at == null) {
            $this->sendOtp();
        }
    }

    public function sendOtp()
    {
        // Clear previous messages
        $this->resetMessages();

        try {
            // Generate a 6-digit OTP
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store OTP and timestamp in session
            session()->put('otp', $otp);
            session()->put('otp_sent_at', Carbon::now());
            session()->put('otp_email', Auth::user()->email);

            // Send OTP to user's email
            Mail::to(Auth::user()->email)->send(new OtpMail($otp));

            // Mark OTP as sent
            $this->otp_sent = true;
            $this->otp_expired = false;

            // Reset OTP input
            $this->otp = ['', '', '', '', '', ''];

            // Start timer
            $this->time_left = 120;
            $this->resend_allowed = true;

            // Success message
            $this->success_message = 'OTP has been sent to your email.';
        } catch (\Exception $e) {
            $this->error_message = 'Failed to send OTP. Please try again.';
            Log::error('OTP Send Error: ' . $e->getMessage());
        }
    }

    public function decrementTimer()
    {
        // Decrement time left
        if ($this->time_left > 0) {
            $this->time_left--;
        } else {
            $this->otp_expired = true;
            $this->resend_allowed = false;
            session()->forget('otp');
            session()->forget('otp_sent_at');
            $this->error_message = 'OTP has expired. Please request a new one.';
        }
    }

    public function verifyOTP()
    {
        // Reset previous messages
        $this->resetMessages();

        // Combine OTP digits
        $enteredOtp = implode('', $this->otp);

        // Validate OTP input
        if (strlen($enteredOtp) !== 6 || !is_numeric($enteredOtp)) {
            $this->error_message = 'Please enter a valid 6-digit OTP.';
            return;
        }

        // Check if OTP is expired
        if (Carbon::now()->diffInSeconds(session('otp_sent_at')) > 120) {
            $this->otp_expired = true;
            session()->forget('otp');
            session()->forget('otp_sent_at');
            $this->error_message = 'OTP has expired. Please request a new one.';
            return;
        }

        // Verify OTP
        if ($enteredOtp == session('otp')) {
            session()->forget('otp');
            session()->forget('otp_sent_at');
            $this->success_message = 'OTP verified successfully!';
            $this->dispatch('otpVerified', true);
            $user = User::find(Auth::id());
            $user->email_verified_at = Carbon::now();
            $user->save();
            Mail::to($user->email)->send(new EmailVerified($user));
        } else {
            $this->error_message = 'Invalid OTP. Please try again.';
            $this->dispatch('otpVerificationFailed', 'Invalid OTP');
        }
    }

    // Reset all messages
    public function resetMessages()
    {
        $this->error_message = '';
        $this->success_message = '';
    }

    public function render()
    {
        return view('livewire.otp-verification');
    }
}
