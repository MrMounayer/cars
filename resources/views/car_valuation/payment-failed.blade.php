@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')
<div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a]">
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="bg-white/90 dark:bg-[#161615]/90 rounded-xl shadow-lg p-8 w-full max-w-xl text-center">
            <div class="mb-6 text-red-600 dark:text-red-400">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold mb-4 text-[#1a237e] dark:text-[#90caf9]">Payment Failed</h1>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] mb-6">{{ $error ?? 'Your payment could not be processed. Please try again.' }}</p>
            
            <div class="flex flex-col space-y-4">
                <a href="{{ route('car-valuation.payment') }}" class="inline-block bg-[#1a237e] dark:bg-[#90caf9] text-white dark:text-[#0a0a0a] font-semibold px-8 py-3 rounded-lg shadow transition-colors text-lg hover:bg-[#3949ab] dark:hover:bg-[#64b5f6]">
                    Try Again
                </a>
                <a href="{{ route('car-valuation.form') }}" class="text-[#1a237e] dark:text-[#90caf9] hover:underline">
                    Start New Valuation
                </a>
            </div>
        </div>
    </main>
</div>
@endsection