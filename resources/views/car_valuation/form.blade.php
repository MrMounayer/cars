
<x-layouts.app>
<div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a]">
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
                    <select id="year" name="year" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" x-data x-init="new TomSelect($el, {searchField: 'text'})">
                        @for ($y = now()->year; $y >= 1970; $y--)
                            <option value="{{ $y }}" @if(old('year') == $y) selected @endif>{{ $y }}</option>
                        @endfor
                    </select>
                    {{-- <input type="number" id="year" name="year" min="1900" max="{{ date('Y') }}" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" value="{{ old('year') }}"> --}}
                </div>
                <div>
                    <label for="mileage" class="block text-sm font-medium mb-1">Mileage</label>
                    <input type="number" id="mileage" name="mileage" min="0" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg" value="{{ old('mileage') }}">
                </div>
                <div>
                    <label for="vin" class="block text-sm font-medium mb-1">VIN Number (Optional)</label>
                    <input type="text" id="vin" name="vin" pattern="^[A-HJ-NPR-Z0-9]{17}$" class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg uppercase" value="{{ old('vin') }}">
                    <p class="mt-1 text-sm text-gray-500">17 characters, letters (except I, O, Q) and numbers</p>
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-[#1a237e] text-white font-semibold rounded-lg shadow hover:bg-[#0d1335] transition-colors text-lg">Get Valuation</button>
            </form>
        </div>
    </main>
    <footer class="mt-10 text-gray-500 text-sm text-center py-6">
        &copy; {{ date('Y') }} Car Valuation App
    </footer>
</div>
</x-layouts.app>

