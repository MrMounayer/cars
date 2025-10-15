<x-layouts.app.sidebar>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Valuation Report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Vehicle Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Vehicle Information</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Make</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->make }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Model</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->model }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Year</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->year }}</p>
                                </div>
                                @if($report->trim)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Trim</p>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->trim }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mileage</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ number_format($report->mileage) }} miles</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ZIP Code</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->zip_code }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Valuation Details -->
                        @if($report->isPaid())
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Valuation Details</h3>
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Minimum Value</p>
                                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">AED {{ number_format($report->min_value) }}</p>
                                    </div>
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Value</p>
                                        <p class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">AED {{ number_format($report->average_value) }}</p>
                                    </div>
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Maximum Value</p>
                                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">AED {{ number_format($report->max_value) }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-600 dark:text-gray-400">Unlock the full valuation report to see detailed pricing information.</p>
                                <button type="button" wire:click="unlockReport" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Unlock Full Report
                                </button>
                            </div>
                        @endif

                        <!-- Report Date -->
                        <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                            Report generated on {{ $report->created_at->format('F j, Y \a\t g:i A') }}
                        </div>

                        <!-- Back Link -->
                        <div class="mt-6">
                            <a href="{{ route('valuation.history') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">&larr; Back to History</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>