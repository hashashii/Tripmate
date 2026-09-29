<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Brand / Logo --}}
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-[24px] font-black text-emerald-600 tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Trip<span class="text-gray-900">Mate</span></span>
                </a>
            </div>

            {{-- Navigation Links (Semantic UL/LI Structure) --}}
            <ul class="hidden md:flex items-center space-x-6 text-sm font-semibold">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') && !request('category') ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600' }} transition-colors">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}?category=1" class="{{ request('category') == 1 ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600' }} transition-colors">
                        Nature & Waterfalls
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}?category=2" class="{{ request('category') == 2 ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600' }} transition-colors">
                        Heritage
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}?category=3" class="{{ request('category') == 3 ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600' }} transition-colors">
                        Adventure
                    </a>
                </li>
            </ul>

            {{-- Action Button --}}
            <div class="flex items-center gap-3">
                <a href="#" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                    + My Trip Plan
                </a>
            </div>

        </div>
    </div>
</nav>