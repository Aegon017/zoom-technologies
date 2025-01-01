<?php

namespace App\Livewire;

use App\Mail\UserEnrollMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class RegisterUser extends Component
{
    public $fullName = '';
    public $email = '';
    public $phone = '';
    public $valid = false;

    public function rules()
    {
        return [
            'fullName' => 'required|min:2|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'max:255',
            ],
            'phone' => [
                'required',
                'unique:users,phone',
            ],
            'valid' => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'fullName.required' => 'Full name is required.',
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already registered.',
            'valid.accepted' => 'Please provide a valid mobile number with country code.',
        ];
    }

    public function register()
    {
        // Validate input
        $validatedData = $this->validate();

        // Generate a random password
        $password = Str::random(12);

        try {
            // Create user
            $user = User::create([
                'name' => $validatedData['fullName'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($password),
            ]);

            // Send welcome email
            Mail::to($user->email)->send(new UserEnrollMail($user, $password));

            // Log in the user
            Auth::login($user);

            // Flash success message
            session()->flash('success', 'Registration Successful');

            // Dispatch event
            $this->dispatch('registration-success');

            // Redirect or reset form
            return redirect()->route('dashboard'); // Adjust route as needed

        } catch (\Exception $e) {
            // Log the error
            logger()->error('Registration failed: ' . $e->getMessage());

            // Flash error message
            session()->flash('error', 'Registration failed. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.register-user');
    }
}
