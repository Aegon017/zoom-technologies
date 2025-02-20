<?php

namespace App\Livewire;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UploadProof extends Component
{
    use WithFileUploads;
    #[Validate('required|image|max:1024')]
    public $photo;

    #[Validate('required|image|max:1024')]
    public $id_card;

    public function save()
    {
        dd(url());
        $this->validate();
        $photoName = $this->photo->getClientOriginalName();
        $idCardName = $this->id_card->getClientOriginalName();
        $photoPath = $this->photo->storeAs('students/photos', $photoName, 'public');
        $idCardPath = $this->photo->storeAs('students/idproofs', $idCardName, 'public');
        $user = User::find(Auth::id());
        $profile = new StudentProfile([
            'photo' => $photoPath,
            'id_card' => $idCardPath
        ]);
        $user->studentProfile()->save($profile);
        flash()->success('successfully saved');
        $this->dispatch('close-upload-profile');
    }

    public function render(): View
    {
        return view('livewire.upload-proof');
    }
}
