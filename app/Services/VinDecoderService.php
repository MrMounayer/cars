<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VinDecoderService
{
    /**
     * Decode a VIN using the NHTSA API (public, no key required).
     * Returns array with decoded data or null on failure.
     */
    public function decode(string $vin): ?array
    {
        $response = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/' . $vin . '?format=json');
        if ($response->successful() && isset($response['Results'])) {
            return $response['Results'];
        }
        return null;
    }
}
