<?php

namespace App\Livewire;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserAddress extends Component
{
    public $showAddressForm  = false;
    public $fAddress = '';
    public $city = '';
    public $state = '';
    public $zipCode = '';
    public $country = '';
    public function toggleAddressForm()
    {
        $this->showAddressForm = !$this->showAddressForm;
    }

    public function save()
    {
        $address = new Address();
        $address->user_id = Auth::user()->id;
        $address->address = $this->fAddress;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zipCode;
        $address->country = $this->country;
        $address->save();
        $this->reset(['fAddress', 'city', 'state', 'zipCode', 'country']);
        $this->showAddressForm = false;
    }

    public function delete($id)
    {
        $address = Address::find($id);
        $address->delete();
    }
    public function render()
    {
        return view('livewire.user-address');
    }
}
