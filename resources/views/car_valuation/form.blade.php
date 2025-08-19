

@extends('layouts.app')

@section('title', 'Car Valuation')

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
            <h1 class="text-3xl font-extrabold mb-4 text-[#1a237e] dark:text-[#90caf9]">Car Valuation Form</h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">Enter your car details to get an instant market valuation.</p>
            <form method="POST" action="{{ route('car-valuation.submit') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="make" class="block text-sm font-medium mb-1">Make</label>
                    <input type="text" id="make" name="make" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" value="{{ old('make') }}">
                </div>
                <div>
                    <label for="model" class="block text-sm font-medium mb-1">Model</label>
                    <input type="text" id="model" name="model" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" value="{{ old('model') }}">
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium mb-1">Year</label>
                    <input type="number" id="year" name="year" min="1900" max="{{ date('Y') }}" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" value="{{ old('year') }}">
                </div>
                <div>
                    <label for="mileage" class="block text-sm font-medium mb-1">Mileage</label>
                    <input type="number" id="mileage" name="mileage" min="0" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" value="{{ old('mileage') }}">
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-[#1a237e] text-white font-semibold rounded-lg shadow hover:bg-[#0d1335] transition-colors text-lg">Get Valuation</button>
            </form>
        </div>
    </main>
    <footer class="mt-10 text-gray-500 text-sm text-center py-6">
        &copy; {{ date('Y') }} Car Valuation App
    </footer>
</div>
@endsection

