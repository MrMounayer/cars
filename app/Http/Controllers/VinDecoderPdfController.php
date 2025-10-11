<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\VinDecoderService;

class VinDecoderPdfController extends Controller
{
    public function download(Request $request)
    {
        $validated = $request->validate([
            'vin' => 'required|string|size:17',
        ]);

        $service = new VinDecoderService();
        $results = $service->decode($validated['vin']);

        $pdf = Pdf::loadView('car_valuation.vin_pdf', [
            'vin' => $validated['vin'],
            'results' => $results,
        ]);

        return $pdf->download('vin-decoder-report-' . $validated['vin'] . '.pdf');
    }
}
