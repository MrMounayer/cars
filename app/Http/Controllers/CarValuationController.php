<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Car;
use App\Services\WebCarValuationService;

class CarValuationController extends Controller
{
    public function showForm()
    {
        return view('car_valuation.form');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'mileage' => 'required|integer|min:0',
        ]);

        // Search for a matching car in the database
        $car = Car::where('make', $validated['make'])
            ->where('model', $validated['model'])
            ->where('year', $validated['year'])
            ->first();


        if ($car) {
            // Adjust price based on mileage: deduct 1% per 10,000 miles from both min and max
            $mileage = $validated['mileage'];
            $depreciation = 1 - (0.01 * floor($mileage / 10000));
            $depreciation = max($depreciation, 0.7); // Don't depreciate below 70% of base value
            $valuation = [
                'min' => round($car->min_price * $depreciation, 2),
                'max' => round($car->max_price * $depreciation, 2),
            ];
        } else {
            // Lookup on the web if not found in DB
            $webService = new WebCarValuationService();
            $valuation = $webService->lookup(
                $validated['make'],
                $validated['model'],
                $validated['year'],
                $validated['mileage'] ?? null
            );
        }

        // dd($valuation);
        return view('car_valuation.result', [
            'valuation' => $valuation,
            'data' => $validated,
        ]);
    }
}
