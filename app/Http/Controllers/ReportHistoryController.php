<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportHistory;

class ReportHistoryController extends Controller
{
    public function index(Request $request)
    {
        $reports = ReportHistory::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('dashboard.report_histories', compact('reports'));
    }
}
