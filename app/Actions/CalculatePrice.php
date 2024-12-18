<?php

namespace App\Actions;

use App\Models\Tax;

class CalculatePrice
{
    public function execute($actualPrice, $salePrice)
    {
        $tax = Tax::first();
        $cgstPercentage = Tax::where('name', 'CGST')->first()->value ?? 0;
        $sgstPercentage = Tax::where('name', 'SGST')->first()->value ?? 0;
        if ($salePrice) {
            $cgst = $salePrice * ($cgstPercentage / 100);
            $sgst = $salePrice * ($sgstPercentage / 100);
            $payablePrice = $salePrice + $cgst + $sgst;
        } else {
            $cgst = $actualPrice * ($cgstPercentage / 100);
            $sgst = $actualPrice * ($sgstPercentage / 100);
            $payablePrice = $actualPrice + $cgst + $sgst;
        }

        return [
            'cgstPercentage' => $cgstPercentage,
            'sgstPercentage' => $sgstPercentage,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'salePrice' => $salePrice,
            'actualPrice' => $actualPrice,
            'payablePrice' => $payablePrice,
        ];
    }
}
