<?php

namespace App\Livewire;

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

    public function applyPromoCode()
    {
        $this->discount = null;
        $redeemer = User::find(Auth::id());
        if ($redeemer) {
            try {
                $coupon = $redeemer->verifyCoupon($this->promoCode);
                $value = $coupon->value;
                $alreadyUsed = $redeemer->isCouponAlreadyUsed($this->promoCode);
                if (!$alreadyUsed) {
                    if ($coupon) {
                        $type = $coupon->type;
                        if ($type === 'percentage') {
                            $this->discount = ($value / 100) * $this->payablePrice;
                        } else {
                            $this->discount = $value;
                        }
                        $this->payablePrice = $this->payablePrice - $this->discount;
                        $redeemer->redeemCoupon($this->promoCode);
                        flash()->success('Promocode reedemed successfully');
                    }
                } else {
                    flash()->error('Promocode already used');
                }
            } catch (\Throwable $th) {
                flash()->error($th->getMessage());
            }
        } else {
            flash()->error('Please Sign In/SignUp to use promocodes');
        }
    }

    public function render()
    {
        return view('livewire.promo-code');
    }
}
