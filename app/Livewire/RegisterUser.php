<?php

namespace App\Livewire;

use App\Mail\UserEnrollMail;
use App\Models\Schedule;
use App\Models\StickyContact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
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
        $validatedData = $this->validate();
        $password = Str::random(12);

        try {
            $user = User::create([
                'name' => $validatedData['fullName'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($password),
            ]);
            $stickyContact = StickyContact::with(['mobileNumber', 'email'])->first();
            Mail::to($user->email)->send(new UserEnrollMail($user, $password, $stickyContact));
            Auth::login($user);
            session()->flash('success', 'Registration Successful');
            $this->dispatch('registration-success');
            $scheduleIds = Session::get('scheduleIDs');
            $hasClassroomTraining = Schedule::whereIn('id', $scheduleIds)
                ->where('training_mode', 'Classroom')
                ->exists();
            if ($hasClassroomTraining) {
                $this->dispatch('show-upload-profile');
            }
        } catch (\Exception $e) {
            logger()->error('Registration failed: ' . $e->getMessage());
            session()->flash('error', 'Registration failed. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.register-user');
    }
}
