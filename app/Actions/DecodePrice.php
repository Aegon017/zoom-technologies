<?php

namespace App\Actions;

use App\Models\Tax;

class DecodePrice
{
    public function execute($payablePrice)
    {
        $cgst = Tax::where('name', 'CGST')->first()->value;
        $sgst = Tax::where('name', 'SGST')->first()->value;
        $cgstPercentage = $cgst;
        $sgstPercentage = $sgst;
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
