<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Car Valuation App</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] antialiased">
        <header class="bg-white/80 dark:bg-[#161615]/80 shadow-sm sticky top-0 z-20">
            <div class="max-w-5xl mx-auto flex items-center justify-between px-6 py-4">
                <span class="font-bold text-2xl text-[#f53003] dark:text-[#FF4433]">Car Valuation App</span>
                <nav class="flex items-center gap-4">
                    <a href="#features" class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4">Features</a>
                    <a href="#testimonials" class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4">Testimonials</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 rounded bg-[#f53003] text-white font-semibold hover:bg-[#d41e00] transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-1.5 rounded border border-[#f53003] text-[#f53003] font-semibold hover:bg-[#f53003] hover:text-white transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-1.5 rounded border border-[#1b1b18] text-[#1b1b18] dark:border-[#EDEDEC] dark:text-[#EDEDEC] font-semibold hover:bg-[#1b1b18] hover:text-white dark:hover:bg-[#EDEDEC] dark:hover:text-[#1b1b18] transition-colors">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 py-12">
            <section class="flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20">
                <div class="flex-1">
                    <h1 class="text-4xl font-extrabold mb-4 text-[#f53003] dark:text-[#FF4433] leading-tight">
                        Get Your Car's Value Instantly
                    </h1>
                    <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] mb-6">
                        Enter your car details and discover its true market value in seconds. Fast, free, and no registration required.
                    </p>
                    <ul class="space-y-3 mb-8" id="features">
                        <li class="flex items-center gap-3">
                            <svg class="size-5 text-[#f53003] dark:text-[#FF4433]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="font-medium">Instant, accurate car valuations</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="size-5 text-[#f53003] dark:text-[#FF4433]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 12l2 2l4-4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="font-medium">Data privacy guaranteed</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="size-5 text-[#f53003] dark:text-[#FF4433]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M13 2L3 14h9l-1 8L21 10h-9l1-8z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="font-medium">No sign-up required</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="size-5 text-[#f53003] dark:text-[#FF4433]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="2" y="7" width="20" height="10" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="font-medium">Powered by a large Dataset, and Ai</span>
                        </li>
                    </ul>
                    <a href="{{ route('car-valuation.form') }}"
                       class="inline-block bg-[#f53003] hover:bg-[#d41e00] text-white font-semibold px-8 py-3 rounded-lg shadow transition-colors text-lg">
                        Get Started
                    </a>
                </div>
                <div class="flex-1 flex justify-center">
                    <div class="relative w-full max-w-md aspect-[4/3] rounded-xl overflow-hidden shadow-lg bg-[#fff2f2] dark:bg-[#1D0002]">
                        <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=600&q=80"
                             alt="Car" class="object-cover w-full h-full" />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#f53003]/70 to-transparent"></div>
                    </div>
                </div>
            </section>

            <section id="testimonials" class="mt-24">
                <h2 class="text-2xl font-bold text-center mb-10 text-[#1b1b18] dark:text-[#EDEDEC]">What Our Users Say</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-xs p-6 flex flex-col items-center text-center">
                        <flux:avatar name="Sarah" class="mb-3" />
                        <p class="text-[#706f6c] dark:text-[#A1A09A] mb-2">“Super easy to use and the valuation was spot on. Helped me negotiate a better price for my car!”</p>
                        <span class="font-semibold text-[#f53003] dark:text-[#FF4433]">Sarah M.</span>
                    </div>
                    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-xs p-6 flex flex-col items-center text-center">
                        <flux:avatar name="James" class="mb-3" />
                        <p class="text-[#706f6c] dark:text-[#A1A09A] mb-2">“No sign-up, no hassle. Got my car's value in seconds. Highly recommend!”</p>
                        <span class="font-semibold text-[#f53003] dark:text-[#FF4433]">James L.</span>
                    </div>
                    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-xs p-6 flex flex-col items-center text-center">
                        <flux:avatar name="Priya" class="mb-3" />
                        <p class="text-[#706f6c] dark:text-[#A1A09A] mb-2">“The interface is beautiful and the results are instant. Love the privacy focus.”</p>
                        <span class="font-semibold text-[#f53003] dark:text-[#FF4433]">Priya S.</span>
                    </div>
                </div>
            </section>
        </main>

        <footer class="mt-16 py-8 text-center text-xs text-[#706f6c] dark:text-[#A1A09A] border-t border-zinc-200 dark:border-zinc-700">
            &copy; {{ date('Y') }} Car Valuation App. Built with Laravel, Livewire & Flux UI.
        </footer>
    </body>
</html>
