<?php

namespace App\Actions;

use App\Models\Tax;

class DecodePrice
{
    public function execute($payablePrice)
    {
        $tax = Tax::first();
        $cgstPercentage = $tax->cgst;
        $sgstPercentage = $tax->sgst;
        $actualPrice = $payablePrice / (1 + ($cgstPercentage + $sgstPercentage) / 100);
        $cgst = $actualPrice * ($cgstPercentage / 100);
        $sgst = $actualPrice * ($sgstPercentage / 100);
        return [
            'cgstPercentage' => $cgstPercentage,
            'sgstPercentage' => $sgstPercentage,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'actualPrice' => $actualPrice
        ];
    }
}
