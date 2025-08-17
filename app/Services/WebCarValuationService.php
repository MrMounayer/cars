<?php

namespace App\Services;

class WebCarValuationService
{
    /**
     * Dummy web lookup for car valuation. Replace with real API/web scraping as needed.
     */
    public function lookup($make, $model, $year, $mileage = null)
    {
        // Simulate a web lookup result
        $baseMin = 8000;
        $baseMax = 12000;
        if ($mileage !== null) {
            $depreciation = 1 - (0.01 * floor($mileage / 10000));
            $depreciation = max($depreciation, 0.7); // Don't depreciate below 70%
            $min = round($baseMin * $depreciation, 2);
            $max = round($baseMax * $depreciation, 2);
        } else {
            $min = $baseMin;
            $max = $baseMax;
        }
        return [
            'min' => $min,
            'max' => $max,
        ];
    }
}
