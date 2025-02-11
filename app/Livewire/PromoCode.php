<?php

namespace App\Livewire;

use App\Actions\CalculatePrice;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use function Flasher\Prime\flash;

class PromoCode extends Component
{
    public $thumbnail;

    public $thumbnail_alt;

    public $actualName;

    public $coursePrice;

    public $sgst;

    public $cgst;

    public $payablePrice;

    public $discount;

    public $promoCode;

    public $subTotal;

    public $productType;

    public $slug;

    public function applyPromoCode()
    {
        $redeemer = User::find(Auth::id());
        if (!$redeemer) {
            flash()->error('Please Sign In/SignUp to use promocodes');
            return;
        }

        try {
            $coupon = $redeemer->verifyCoupon($this->promoCode);
            if (!$coupon) {
                flash()->error('Invalid promocode');
                return;
            }
            $couponCode = Coupon::find($coupon->id);
            if (!$couponCode->courses->contains('slug', $this->slug) && !$couponCode->packages->contains('slug', $this->slug)) {
                flash()->error('This promo code is not valid for the selected course or package');
                return;
            }

            if ($redeemer->isCouponAlreadyUsed($this->promoCode)) {
                flash()->error('Promo code has already been used');
                return;
            }

            $this->discount = $coupon->type === 'percentage'
                ? ($coupon->value / 100) * $this->coursePrice
                : $coupon->value;

            $this->discount = min($this->discount, $this->coursePrice);

            $this->subTotal = $this->coursePrice - $this->discount;
            $calculatePrice = new CalculatePrice();
            $prices = $calculatePrice->execute($this->subTotal, null);
            $this->sgst = $prices['sgst'];
            $this->cgst = $prices['cgst'];
            $this->payablePrice = $prices['payablePrice'];
            $this->dispatch('promo-code-applied', payablePrice: $this->payablePrice, discount: $this->discount, couponId: $coupon->id);
            flash()->success('Promo code applied successfully');
        } catch (\Throwable $th) {
            flash()->error('An error occurred: ' . $th->getMessage());
        }
    }

    public function removePromoCode()
    {
        $this->promoCode = null;
        $this->discount = null;
        $calculatePrice = new CalculatePrice();
        $prices = $calculatePrice->execute($this->coursePrice, null);
        $this->sgst = $prices['sgst'];
        $this->cgst = $prices['cgst'];
        $this->payablePrice = $prices['payablePrice'];
        $this->dispatch('promo-code-removed');
    }

    public function render()
    {
        return view('livewire.promo-code');
    }
}
