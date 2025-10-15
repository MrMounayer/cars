@extends('layouts.app')

@section('title', 'Payment Success')

@section('content')
<div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a]">
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="bg-white/90 dark:bg-[#161615]/90 rounded-xl shadow-lg p-8 w-full max-w-xl text-center">
            <div class="mb-6 text-green-600 dark:text-green-400">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold mb-4 text-[#1a237e] dark:text-[#90caf9]">Payment Successful!</h1>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] mb-6">Your payment has been processed successfully. Your report is ready to view.</p>
            
            <div class="flex flex-col space-y-4">
                <a href="{{ route('valuation.show', $report) }}" class="inline-block bg-[#1a237e] dark:bg-[#90caf9] text-white dark:text-[#0a0a0a] font-semibold px-8 py-3 rounded-lg shadow transition-colors text-lg hover:bg-[#3949ab] dark:hover:bg-[#64b5f6]">
                    View Your Report
                </a>
                <a href="{{ route('valuation.history') }}" class="text-[#1a237e] dark:text-[#90caf9] hover:underline">
                    View All Reports
                </a>
            </div>
        </div>
    </main>
</div>
@endsection