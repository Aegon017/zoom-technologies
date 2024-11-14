<?php

namespace App\Actions\Payment;

use App\Models\Course;
use App\Models\Package;

class ModelFromProductType
{
    public function execute(string $productType)
    {
        return match ($productType) {
            'course' => Course::class,
            'package' => Package::class,
            default => throw new \InvalidArgumentException("Unknown product type: $productType"),
        };
    }
}
