<?php

namespace App\Livewire;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    public $addresses;

    public $addressId = '';

    public $faddress = '';

    public $city = '';

    public $state = '';

    public $zip_code = '';

    public $country = '';

    public function mount()
    {
        $addresses = Address::where('user_id', Auth::id())->first();
        if ($addresses) {
            $this->faddress = $addresses->address;
            $this->city = $addresses->city;
            $this->state = $addresses->state;
            $this->zip_code = $addresses->zip_code;
            $this->country = $addresses->country;
        }
    }

    public function updateAddress()
    {
        if (Auth::user()->addresses) {
            Auth::user()->addresses->update([
                'address' => $this->faddress,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
                'country' => $this->country,
            ]);
            $this->dispatch('updated');
        } else {
            Address::create([
                'user_id' => Auth::id(),
                'address' => $this->faddress,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
                'country' => $this->country,
            ]);
            $this->dispatch('updated');
        }
    }

    public function render()
    {
        return view('livewire.update-address-form');
    }
}
