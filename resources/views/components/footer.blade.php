<footer class="bg-gray-900 text-gray-300 border-t border-gray-800 pt-12 pb-8">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Footer Main Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-gray-800">
            
            {{-- Column 1: Brand & About --}}
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="text-[24px] font-black text-emerald-500 tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Trip<span class="text-white">Mate</span></span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Discover Sri Lanka's finest destinations, waterfalls, and heritage spots with live navigation and interactive maps.
                </p>
            </div>

            {{-- Column 2: Quick Links --}}
            <div>
                <h4 class="text-white text-base font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm font-medium">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}?category=1" class="hover:text-emerald-400 transition-colors">Nature & Waterfalls</a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}?category=2" class="hover:text-emerald-400 transition-colors">Heritage Spots</a>
                    </li>
                </ul>
            </div>

            {{-- Column 3: Destination Categories --}}
            <div>
                <h4 class="text-white text-base font-bold mb-4">Top Categories</h4>
                <ul class="space-y-2 text-sm font-medium">
                    <li>
                        <a href="#" class="hover:text-emerald-400 transition-colors">Beaches & Coastal</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-emerald-400 transition-colors">Hiking & Camping</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-emerald-400 transition-colors">Historical Shrines</a>
                    </li>
                </ul>
            </div>

            {{-- Column 4: Newsletter / Contact --}}
            <div>
                <h4 class="text-white text-base font-bold mb-4">Stay Connected</h4>
                <p class="text-sm text-gray-400 mb-3">
                    Plan your custom itinerary with our interactive route generator.
                </p>
                <a href="#" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm w-full text-center">
                    + Plan My Trip
                </a>
            </div>

        </div>

        {{-- Footer Bottom Copyright --}}
        <div class="pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 gap-4">
            <p>&copy; {{ date('Y') }} TripMate. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-gray-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-400 transition-colors">Terms of Service</a>
            </div>
        </div>

    </div>
</footer>