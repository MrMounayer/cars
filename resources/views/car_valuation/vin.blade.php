@extends('layouts.app')

@section('title', 'VIN Decoder')

@section('content')
<div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a]">
    <header class="bg-white/80 dark:bg-[#161615]/80 shadow-sm sticky top-0 z-20">
        <div class="max-w-5xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="/" class="font-bold text-2xl text-[#1a237e] dark:text-[#90caf9]">Car Valuation App</a>
            <nav class="flex items-center gap-4">
                <a href="/" class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4">Home</a>
                <a href="{{ route('car-valuation.form') }}" class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4">Valuation</a>
                <a href="{{ route('vin.form') }}" class="text-sm text-[#1a237e] dark:text-[#90caf9] font-semibold underline underline-offset-4">VIN Decoder</a>
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-[#1a237e] hover:underline underline-offset-4">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-[#1a237e] hover:underline underline-offset-4">Register</a>
                @else
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-[#1a237e] hover:underline underline-offset-4 ml-2">Logout</button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="bg-white/90 dark:bg-[#161615]/90 rounded-xl shadow-lg p-8 w-full max-w-2xl">
            <h1 class="text-3xl font-extrabold mb-4 text-[#1a237e] dark:text-[#90caf9]">VIN Decoder</h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">Enter your 17-character VIN to decode your vehicle's details instantly.</p>
            <form method="POST" action="{{ route('vin.decode') }}" class="flex flex-col gap-4 mb-8">
                @csrf
                <input type="text" name="vin" value="{{ old('vin', $vin ?? '') }}" maxlength="17" minlength="17" required placeholder="Enter 17-character VIN" class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg">
                @error('vin')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
                <button type="submit" class="w-full px-6 py-3 bg-[#1a237e] text-white font-semibold rounded-lg shadow hover:bg-[#0d1335] transition-colors text-lg">Decode VIN</button>
            </form>
            @isset($results)
                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4 text-[#1a237e] dark:text-[#90caf9]">Decoded VIN Data</h2>
                    <div class="overflow-x-auto max-h-96 rounded border border-zinc-200 dark:border-[#3E3E3A] bg-zinc-50 dark:bg-[#1D0002]">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-100 dark:bg-[#161615]">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Vehicle Data</th>
                                    <th class="px-3 py-2 text-left font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $item)
                                @if(!empty($item['Value']))
                                    <tr class="even:bg-zinc-50 odd:bg-white dark:even:bg-[#161615] dark:odd:bg-[#1D0002]">
                                        <td class="px-3 py-2 border-b border-zinc-200 dark:border-[#3E3E3A]">{{ $item['Variable'] }}</td>
                                        <td class="px-3 py-2 border-b border-zinc-200 dark:border-[#3E3E3A]">{{ $item['Value'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset
        </div>
    </main>
    <footer class="mt-10 text-gray-500 text-sm text-center py-6">
        &copy; {{ date('Y') }} Car Valuation App
    </footer>
</div>
@endsection
