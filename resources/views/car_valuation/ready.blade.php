@extends('layouts.app')

@section('title', 'Valuation Ready')

@section('content')
<div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a]">
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="bg-white/90 dark:bg-[#161615]/90 rounded-xl shadow-lg p-8 w-full max-w-xl text-center">
            <h1 class="text-3xl font-extrabold mb-4 text-[#1a237e] dark:text-[#90caf9]">Your Valuation is Ready!</h1>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] mb-6">To view your car's market value, please complete the payment step below.</p>
            <a href="{{ route('car-valuation.payment') }}" class="inline-block bg-[#1a237e] dark:bg-[#90caf9] text-white dark:text-[#0a0a0a] font-semibold px-8 py-3 rounded-lg shadow transition-colors text-lg hover:bg-[#3949ab] dark:hover:bg-[#64b5f6]">Proceed to Payment</a>
        </div>
    </main>
</div>
@endsection
