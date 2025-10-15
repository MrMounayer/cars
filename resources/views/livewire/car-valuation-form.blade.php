<div class="flex flex-col gap-4">
    <form wire:submit="submit" class="flex flex-col gap-4">
        <div>
            <label for="make" class="block text-sm font-medium mb-1">Make</label>
            <input type="text" id="make" wire:model="make" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg">
            @error('make') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="model" class="block text-sm font-medium mb-1">Model</label>
            <input type="text" id="model" wire:model="model" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg">
            @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="year" class="block text-sm font-medium mb-1">Year</label>
            <flux:select
                id="year"
                wire:model="year"
                :options="$years"
                searchable
                label="Year"
                :clearable="false"
                class="w-full"
                placeholder="Select Year"
            />
            @error('year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="mileage" class="block text-sm font-medium mb-1">Mileage</label>
            <input type="number" id="mileage" wire:model="mileage" min="0" required class="w-full px-4 py-3 border border-[#1a237e] rounded focus:ring-2 focus:ring-[#1a237e] focus:outline-none text-lg">
            @error('mileage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-[#1a237e] text-white font-semibold rounded-lg shadow hover:bg-[#0d1335] transition-colors text-lg">Get Valuation</button>
    </form>
</div>