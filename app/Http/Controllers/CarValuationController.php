<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Car;
use App\Services\CarValuationService;

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


        $valuationService = new CarValuationService();
        $valuation = $valuationService->getValuation(
            $validated['make'],
            $validated['model'],
            $validated['year'],
            $validated['mileage'] ?? null
        );

        // dd($valuation);
        return view('car_valuation.result', [
            'valuation' => $valuation,
            'data' => $validated,
        ]);
    }
}
