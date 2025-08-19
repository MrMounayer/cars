<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VinDecoderService;

class VinDecoderController extends Controller
{
    public function showForm()
    {
        return view('car_valuation.vin');
    }

    public function decode(Request $request)
    {
        $validated = $request->validate([
            'vin' => 'required|string|size:17',
        ]);

        $service = new VinDecoderService();
        $results = $service->decode($validated['vin']);

        // dd($results);
        return view('car_valuation.vin', [
            'vin' => $validated['vin'],
            'results' => $results,
        ]);
    }
}
