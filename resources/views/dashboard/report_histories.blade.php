<x-layouts.app :title="__('Report History')">

<div class="max-w-5xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8 text-[#1a237e] dark:text-[#90caf9]">My Report History</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-[#161615] rounded shadow">
            <thead>
                <tr class="bg-[#e3eafc] dark:bg-[#233366] text-[#1a237e] dark:text-[#90caf9]">
                    <th class="px-4 py-2 text-left">Type</th>
                    <th class="px-4 py-2 text-left">Input</th>
                    <th class="px-4 py-2 text-left">Result</th>
                    <th class="px-4 py-2 text-left">Payment Ref</th>
                    <th class="px-4 py-2 text-left">Paid At</th>
                    <th class="px-4 py-2 text-left">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr class="border-b border-[#e3eafc] dark:border-[#233366]">
                        <td class="px-4 py-2">{{ ucfirst($report->type) }}</td>
                        <td class="px-4 py-2 text-xs">{{ json_encode($report->input_data) }}</td>
                        <td class="px-4 py-2 text-xs">{{ json_encode($report->result_data) }}</td>
                        <td class="px-4 py-2">{{ $report->payment_reference }}</td>
                        <td class="px-4 py-2">{{ $report->paid_at ? $report->paid_at->format('Y-m-d H:i') : '-' }}</td>
                        <td class="px-4 py-2">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-[#706f6c]">No reports found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $reports->links() }}</div>
</div>

</x-layouts.app>