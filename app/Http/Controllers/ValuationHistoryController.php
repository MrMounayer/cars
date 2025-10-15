<?php

namespace App\Http\Controllers;

use App\Models\CarValuationReport;
use Illuminate\Http\Request;

class ValuationHistoryController extends Controller
{
    public function index()
    {
        $reports = CarValuationReport::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.valuation.history', compact('reports'));
    }

    public function show(CarValuationReport $report)
    {
        // Ensure the user can only view their own reports
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        return view('livewire.valuation.show', compact('report'));
    }
}