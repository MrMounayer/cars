<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-8">
            <h2 class="text-2xl font-bold mb-6">API Tokens</h2>
            @if(session('token'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded flex items-center gap-2">
                    <span>New Token:</span>
                    <code id="new-api-token" class="break-all">{{ session('token') }}</code>
                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('new-api-token').textContent)" class="ml-2 px-2 py-1 bg-[#1a237e] text-white rounded text-xs hover:bg-[#0d1335]">Copy</button>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.api-tokens.store') }}" class="mb-8 flex gap-2">
                @csrf
                <input type="text" name="token_name" placeholder="Token Name" class="border rounded px-3 py-2 flex-1" required>
                <button type="submit" class="bg-[#1a237e] text-white px-4 py-2 rounded">Create Token</button>
            </form>
            <h3 class="text-lg font-semibold mb-2">Your Tokens</h3>
            <div x-data="{ search: '' }">
                <input type="text" x-model="search" placeholder="Search tokens..." class="mb-3 px-3 py-2 border rounded w-full" />
                <ul class="space-y-2">
                    @php $tokens = auth()->user()->tokens ?? collect(); @endphp
                    @forelse($tokens as $token)
                        <li x-show="'{{ strtolower($token->name) }}'.includes(search.toLowerCase())" class="flex items-center justify-between bg-gray-100 rounded px-3 py-2">
                            <span>{{ $token->name }}</span>
                            <form method="POST" action="{{ route('admin.api-tokens.destroy', $token->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-gray-500">No tokens found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
