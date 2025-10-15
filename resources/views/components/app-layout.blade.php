<x-layouts.app.sidebar>
    <main class="flex-1">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            @if(isset($header))
                <div class="mb-6">
                    {{ $header }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>
</x-layouts.app.sidebar>