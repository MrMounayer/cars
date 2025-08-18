<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class ExternalCarValuationApiService
{
    /**
     * Attempt to get car valuation from an external API.
     * Throws on failure.
     */
    public function getValuation($make, $model, $year, $mileage = null)
    {
        // Example: Replace with real API endpoint and logic
        $url = 'https://api.example.com/car-valuation';
        $params = [
            'make' => $make,
            'model' => $model,
            'year' => $year,
            'mileage' => $mileage,
        ];
        try {
            $response = Http::timeout(5)->get($url, $params);
            if ($response->successful() && isset($response['min'], $response['max'])) {
                return [
                    'min' => $response['min'],
                    'max' => $response['max'],
                ];
            }
            throw new Exception('API did not return valid data');
        } catch (Exception $e) {
            throw new Exception('External API call failed: ' . $e->getMessage());
        }
    }
}
