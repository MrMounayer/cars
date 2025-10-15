<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Valuation Report Details
            </h2>
            <a href="{{ route('valuation.history') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                ← Back to History
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(!$report->isPaid())
                        <div class="mb-6 bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                        Unlock Full Report
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                            Purchase the full report to see detailed valuation information and market analysis.
                                        </p>
                                        <div class="mt-4">
                                            <a href="{{ route('car-valuation.process-payment', ['report' => $report->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Unlock Now for  3.99 AED
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Vehicle Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Vehicle Information</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Make</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->make }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Model</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->model }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Year</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->year }}</dd>
                                </div>
                                @if($report->trim)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Trim</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->trim }}</dd>
                                    </div>
                                @endif
                                @if($report->vin)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">VIN</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->vin }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Valuation Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Valuation Details</h3>
                            @if($report->isPaid())
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Minimum Value</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">AED {{ number_format($report->min_value) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Maximum Value</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">AED {{ number_format($report->max_value) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Value</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">AED {{ number_format($report->average_value) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Report Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->formatted_date }}</dd>
                                    </div>
                                </dl>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">Purchase the full report to see detailed valuation information.</p>
                                </div>
                            @endif
                        </div>

                        @if($report->isPaid() && $report->additional_data)
                            <!-- Market Analysis -->
                            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
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
                            @foreach($report->additional_data as $item)
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>