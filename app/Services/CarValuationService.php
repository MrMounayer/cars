<?php

namespace App\Services;

use App\Models\Car;
use App\Services\WebCarValuationService;
use App\Services\ExternalCarValuationApiService;

class CarValuationService
{
    /**
     * Get valuation for a car, either from DB or web, with mileage depreciation logic.
     */
    public function getValuation($make, $model, $year, $mileage = null)
    {
        $car = Car::where('make', $make)
            ->where('model', $model)
            ->where('year', $year)
            ->first();

        if ($car) {
            $depreciation = 1;
            if ($mileage !== null) {
                $depreciation = 1 - (0.01 * floor($mileage / 10000));
                $depreciation = max($depreciation, 0.7); // Don't depreciate below 70%
            }
            return [
                'min' => round($car->min_price * $depreciation, 2),
                'max' => round($car->max_price * $depreciation, 2),
            ];
        }

        // Try web lookup
        $webService = new WebCarValuationService();
        $valuation = $webService->lookup($make, $model, $year, $mileage);
        if ($valuation && isset($valuation['min'], $valuation['max'])) {
            return $valuation;
        }

        // Failover: Try external API
        try {
            $apiService = new ExternalCarValuationApiService();
            return $apiService->getValuation($make, $model, $year, $mileage);
        } catch (\Exception $e) {
            // Optionally log error here
            return [
                'min' => null,
                'max' => null,
                'error' => 'Valuation unavailable: ' . $e->getMessage(),
            ];
        }
    }
}
