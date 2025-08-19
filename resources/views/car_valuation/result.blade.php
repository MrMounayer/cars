

@extends('layouts.app')

@section('title', 'Car Valuation Result')

@section('content')
<div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a]">
    <header class="bg-white/80 dark:bg-[#161615]/80 shadow-sm sticky top-0 z-20">
        <div class="max-w-5xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="/" class="font-bold text-2xl text-[#1a237e] dark:text-[#90caf9]">Car Valuation App</a>
            <nav class="flex items-center gap-4">
                <a href="/" class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4">Home</a>
                <a href="{{ route('car-valuation.form') }}" class="text-sm text-[#1a237e] dark:text-[#90caf9] font-semibold underline underline-offset-4">Valuation</a>
                <a href="{{ route('vin.form') }}" class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4">VIN Decoder</a>
            </nav>
        </div>
    </header>
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="bg-white/90 dark:bg-[#161615]/90 rounded-xl shadow-lg p-8 w-full max-w-2xl">
            <h1 class="text-3xl font-extrabold mb-4 text-[#1a237e] dark:text-[#90caf9]">Car Valuation Result</h1>
            <div class="mb-6 grid grid-cols-2 gap-4 text-[#706f6c] dark:text-[#A1A09A]">
                <div><span class="font-semibold">Make:</span> {{ $data['make'] }}</div>
                <div><span class="font-semibold">Model:</span> {{ $data['model'] }}</div>
                <div><span class="font-semibold">Year:</span> {{ $data['year'] }}</div>
                <div><span class="font-semibold">Mileage:</span> {{ $data['mileage'] }}</div>
            </div>
            <hr class="my-6 border-[#1a237e]/30 dark:border-[#90caf9]/30">
            @if(is_array($valuation) && isset($valuation['min'], $valuation['max']))
                <div class="flex flex-col items-center gap-2 mb-6">
                    <span class="text-lg text-[#706f6c] dark:text-[#A1A09A]">Estimated Value Range</span>
                    <div class="flex gap-8">
                        <div class="flex flex-col items-center">
                            <span class="text-xs text-[#A1A09A]">Min</span>
                            <span class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">${{ number_format($valuation['min'], 2) }}</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-xs text-[#A1A09A]">Max</span>
                            <span class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">${{ number_format($valuation['max'], 2) }}</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-xs text-[#A1A09A]">Average</span>
                            <span class="text-2xl font-bold text-[#1a237e] dark:text-[#90caf9]">${{ number_format(($valuation['min'] * 0.4 + $valuation['max'] * 0.6), 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-center text-[#706f6c] dark:text-[#A1A09A] mb-4">
                    This is an estimated market value based on your car details.
                </div>
            @else
                <div class="flex flex-col items-center gap-2 mb-6">
                    <span class="text-lg text-[#1a237e] dark:text-[#90caf9] font-semibold">Sorry!</span>
                    <span class="text-[#706f6c] dark:text-[#A1A09A]">No valuation found for the specified car.</span>
                </div>
            @endif
            <a href="{{ route('car-valuation.form') }}" class="inline-block w-full px-6 py-3 bg-[#1a237e] text-white font-semibold rounded-lg shadow hover:bg-[#0d1335] transition-colors text-lg text-center mt-2">Back to Form</a>
        </div>
    </main>
    <footer class="mt-10 text-gray-500 text-sm text-center py-6">
        &copy; {{ date('Y') }} Car Valuation App
    </footer>
</div>
@endsection
