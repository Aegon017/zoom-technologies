<?php

namespace App\Livewire;

use App\Mail\UserEnrollMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Support\Str;

class UserRegister extends Component
{
    public $email = '';
    public $phone = '';
    public $fullName = '';
    public $status = false;
    public $successMessage = '';
    public function register()
    {
        $user = new User();
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
