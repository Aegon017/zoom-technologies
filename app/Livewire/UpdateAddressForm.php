<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    public $addresses = [];
    public $addressId = "";
    public $address = "";
    public $city = "";
    public $state = "";
    public $zip_code = "";
    public $country = "";

    public function mount()
    {
        $this->addresses = Auth::user()->addresses;
        foreach ($this->addresses as $address) {
            $this->addressId = $address->id;
            $this->address = $address->address;
            $this->city = $address->city;
            $this->state = $address->state;
            $this->zip_code = $address->zip_code;
            $this->country = $address->country;
        }
    }

    public function updateAddress()
    {
        $address = Address::find($this->addressId);
        $address->update([
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
        ]);
        $this->dispatch('updated');
    }

    public function delete()
    {
        $address = Address::find($this->addressId);
        $address->delete();
        $this->dispatch('deleted');
        return redirect('/user/profile');
    }
    public function render()
    {
        return view('livewire.update-address-form');
    }
}
