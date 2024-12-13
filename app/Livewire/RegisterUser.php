<?php

namespace App\Livewire;

use App\Mail\OtpMail;
use App\Mail\UserEnrollMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

use function Flasher\Prime\flash;

class RegisterUser extends Component
{
    public $fullName = '';

    public $email = '';

    public $phone = '';

    public $otp = '';

    public function rules()
    {
        return [
            'fullName' => 'required|min:2',
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'phone' => [
                'unique:users,phone',
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already registered.',
        ];
    }

    public function register()
    {
        $password = Str::random(8);
        $validatedData = $this->validate();
        $user = User::create([
            'name' => $validatedData['fullName'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => $password,
        ]);
        if ($user) {
            Mail::to($user->email)->send(new UserEnrollMail($user, $password));
            Auth::login($user);
            flash()->success('Registration Successful');
            $this->dispatch('reload-page');
        }
    }

    public function render()
    {
        return view('livewire.register-user');
    }
}
