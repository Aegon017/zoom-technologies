<?php

namespace App\Livewire;

use App\Mail\UserEnrollMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class UserRegister extends Component
{
    public $email = '';

    public $phone = '';

    public $fullName = '';

    public $status = false;

    public $successMessage = '';

    public $errorMessage = null;

    public function register()
    {
        $existingEmail = User::where('email', $this->email)->first();
        if ($existingEmail) {
            $this->errorMessage = 'The email address is already registered.';

            return;
        }

        $existingPhone = User::where('phone', $this->phone)->first();
        if ($existingPhone) {
            $this->errorMessage = 'The phone number is already registered.';

            return;
        }
        $user = new User;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->name = $this->fullName;
        $password = Str::random(8);
        $user->password = $password;
        $user->save();
        Auth::loginUsingId($user->id);
        Mail::to($user->email)->send(new UserEnrollMail($user, $password));
        $user->sendEmailVerificationNotification();
    }

    public function resendMail()
    {
        if (Auth::user()) {
            $user = User::find(Auth::id());
            $user->sendEmailVerificationNotification();
            $this->successMessage = 'Verification email has been resent successfully!';
        }
    }

    public function checkVerificationStatus()
    {
        if (Auth::check() && Auth::user()->email_verified_at) {
            $this->status = true;
        }
    }

    public function mount()
    {
        if (Auth::check()) {
            $this->checkVerificationStatus();
        }
    }

    public function render()
    {
        return view('livewire.user-register');
    }
}
