<?php

namespace App\Livewire;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BillingAddress extends Component
{
    public $streetAddress = '';

    public $city = '';

    public $state = '';

    public $zipCode = '';

    public $country = '';

    public function save()
    {
        if (Auth::user()->addresses) {
            $address = Auth::user()->addresses->update([
                'address' => $this->streetAddress,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zipCode,
                'country' => $this->country,
            ]);
            if ($address) {
                flash()->success('Billing Address Updated Successfully');
                $this->dispatch('show-pay-button');
            }
        } else {
            $address = Address::create([
                'user_id' => Auth::id(),
                'address' => $this->streetAddress,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zipCode,
                'country' => $this->country,
            ]);
            if ($address) {
                flash()->success('Billing Address Saved Successfully');
                $this->dispatch('show-pay-button');
            }
        }
    }

    public function mount()
    {
        $address = Address::where('user_id', Auth::id())->first();
        if ($address) {
            $this->streetAddress = $address->address;
            $this->city = $address->city;
            $this->state = $address->state;
            $this->zipCode = $address->zip_code;
            $this->country = $address->country;
        }
    }

    public function render()
    {
        return view('livewire.billing-address');
    }
}
