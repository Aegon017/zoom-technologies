<?php

namespace App\Livewire;

use App\Actions\CalculatePrice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use function Flasher\Prime\flash;

class PromoCode extends Component
{
    public $coursePrice;

    public $sgst;

    public $cgst;

    public $payablePrice;

    public $discount;

    public $promoCode;

    public $subTotal;

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
            $alreadyUsed = $redeemer->isCouponAlreadyUsed($this->promoCode);
            if ($alreadyUsed) {
                flash()->error('Promocode already used');
                return;
            }
            $value = $coupon->value;
            $type = $coupon->type;
            $this->discount = $type === 'percentage'
                ? ($value / 100) * $this->coursePrice
                : $value;
            $this->subTotal = $coupon->calc($this->coursePrice);
            $calculatePrice = new CalculatePrice();
            $prices = $calculatePrice->execute($this->subTotal, null);
            $this->sgst = $prices['sgst'];
            $this->cgst = $prices['cgst'];
            $this->payablePrice = $prices['payablePrice'];
            // $redeemer->redeemCoupon($this->promoCode);
            $this->dispatch('promo-code-applied', payablePrice: $this->payablePrice, discount: $this->discount);
            flash()->success('Promocode Applied');
        } catch (\Throwable $th) {
            flash()->error($th->getMessage());
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
