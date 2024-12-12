<?php

namespace App\Livewire;

use App\Mail\UserEnrollMail;
use App\Models\Address;
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

    public $fAddress = '';

    public $city = '';

    public $state = '';

    public $zipCode = '';

    public $country = '';

    public function register()
    {
        if (Auth::guest()) {
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
        }
        $this->addressStore();
    }

    public function addressUpdate()
    {
        $address = Address::where('user_id', Auth::id())->first();
        $address->address = $this->fAddress;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->country = $this->country;
        $address->zip_code = $this->zipCode;
        $address->save();
        $this->successMessage = 'Address updated';
    }

    public function addressStore()
    {
        $address = new Address;
        $address->user_id = Auth::id();
        $address->address = $this->fAddress;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->country = $this->country;
        $address->zip_code = $this->zipCode;
        $address->save();

        return redirect()->back();
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

        if (Auth::user() && Auth::user()->addresses) {
            $address = Address::where('user_id', Auth::id())->first();
            $this->fAddress = $address->address;
            $this->city = $address->city;
            $this->state = $address->state;
            $this->country = $address->country;
            $this->zipCode = $address->zip_code;
        }
    }

    public function isFormValid()
    {
        try {
            $this->validate([
                'fAddress' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'zipCode' => 'required',
            ]);

            return ! empty($this->fAddress) &&
                ! empty($this->city) &&
                ! empty($this->state) &&
                ! empty($this->country) &&
                ! empty($this->zipCode);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }
    }

    public function render()
    {
        return view('livewire.user-register', [
            'isFormValid' => $this->isFormValid(),
        ]);
    }
}
