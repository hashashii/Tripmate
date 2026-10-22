@extends('layouts.app')

@section('title', 'About - TripMate')

@section('content')
    @php
        $placeCount    = \App\Models\Place::count();
        $categoryCount = \App\Models\Category::count();
        $categories    = \App\Models\Category::orderBy('name')->get();
    @endphp

    <div class="mx-auto max-w-6xl">

        {{-- ================= HERO ================= --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 text-white px-6 py-16 sm:py-20 text-center shadow-lg">
            <div class="absolute -top-16 -left-16 w-56 h-56 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-20 -right-10 w-72 h-72 rounded-full bg-white/10"></div>

            <div class="relative">
                <span class="inline-block bg-white/20 backdrop-blur px-4 py-1 rounded-full text-xs font-semibold tracking-wide uppercase">
                    About Us
                </span>
                <h1 class="mt-5 text-4xl sm:text-5xl font-black tracking-tight">
                    Plan your perfect <span class="text-yellow-200">day trip</span>
                </h1>
                <p class="mt-5 max-w-2xl mx-auto text-emerald-50 text-lg leading-relaxed">
                    TripMate brings the best tourist places around you into one simple website, so you can
                    explore, choose and plan a one-day visit without the hassle.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('home') }}"
                       class="bg-white text-emerald-700 font-semibold px-6 py-3 rounded-lg shadow hover:bg-emerald-50 transition-colors">
                        Explore Places
                    </a>
                    <a href="{{ route('trip-plans.create') }}"
                       class="border border-white/70 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors">
                        Plan a Trip
                    </a>
                </div>
            </div>
        </section>

        {{-- ================= STATS ================= --}}
        <section class="-mt-8 relative px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white rounded-2xl border border-gray-100 shadow-md p-6 text-center">
                <div>
                    <p class="text-3xl font-black text-emerald-600">{{ $placeCount }}</p>
                    <p class="mt-1 text-sm text-gray-500">Tourist places</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-emerald-600">{{ $categoryCount }}</p>
                    <p class="mt-1 text-sm text-gray-500">Categories</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-emerald-600">25 km</p>
                    <p class="mt-1 text-sm text-gray-500">Within reach</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-emerald-600">1 day</p>
                    <p class="mt-1 text-sm text-gray-500">Easy trip plans</p>
                </div>
            </div>
        </section>

        {{-- ================= MISSION ================= --}}
        <section class="mt-16 grid gap-8 md:grid-cols-2 items-center">
            <div>
                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">Our purpose</p>
                <h2 class="mt-2 text-3xl font-bold text-gray-900">Why TripMate?</h2>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Planning even a short trip usually means searching many websites, comparing distances and
                    checking whether a place is safe to visit. Information is scattered and often incomplete.
                </p>
                <p class="mt-3 text-gray-600 leading-relaxed">
                    TripMate puts descriptions, photos, distances, facilities, safety information and the map
                    location of each place in one spot, and lets you turn your favourite places into a
                    one-day trip plan in a few clicks.
                </p>
            </div>

            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 space-y-4">
                <div class="flex gap-3">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold">1</span>
                    <p class="text-gray-700"><span class="font-semibold">Make planning easier and faster</span> with everything in one place.</p>
                </div>
                <div class="flex gap-3">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold">2</span>
                    <p class="text-gray-700"><span class="font-semibold">Help you find the right places</span> using search and categories.</p>
                </div>
                <div class="flex gap-3">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold">3</span>
                    <p class="text-gray-700"><span class="font-semibold">Keep you informed</span> with facilities and safety guidance.</p>
                </div>
            </div>
        </section>

        {{-- ================= FEATURES ================= --}}
        <section class="mt-20">
            <div class="text-center">
                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">Features</p>
                <h2 class="mt-2 text-3xl font-bold text-gray-900">Everything you need for a day out</h2>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-gray-900">Search and filter</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Find places by name or browse by category such as nature, heritage and adventure.</p>
                </div>

                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-gray-900">Detailed place information</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Read descriptions, see the distance, available facilities and visitor information.</p>
                </div>

                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-gray-900">Photo gallery</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Browse photos of each place and click any picture to view it in full size.</p>
                </div>

                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-gray-900">Map location</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">See exactly where a place is on the map before you decide to visit.</p>
                </div>

                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-gray-900">Safety information</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Check safety tips, rules and restrictions so you can visit with confidence.</p>
                </div>

                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-gray-900">One-day trip planner</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Choose your places, set a visit date and save your plan. No account needed.</p>
                </div>

            </div>
        </section>

        {{-- ================= HOW IT WORKS ================= --}}
        <section class="mt-20">
            <div class="text-center">
                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">How it works</p>
                <h2 class="mt-2 text-3xl font-bold text-gray-900">Plan a trip in three steps</h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-emerald-600 text-white text-xl font-black flex items-center justify-center shadow">1</div>
                    <h3 class="mt-4 font-bold text-gray-900">Explore</h3>
                    <p class="mt-2 text-sm text-gray-600">Browse or search the places near you and filter by category.</p>
                </div>
                <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-emerald-600 text-white text-xl font-black flex items-center justify-center shadow">2</div>
                    <h3 class="mt-4 font-bold text-gray-900">Choose</h3>
                    <p class="mt-2 text-sm text-gray-600">Open a place to read the details, view photos and check the map.</p>
                </div>
                <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-emerald-600 text-white text-xl font-black flex items-center justify-center shadow">3</div>
                    <h3 class="mt-4 font-bold text-gray-900">Plan</h3>
                    <p class="mt-2 text-sm text-gray-600">Add your favourite places to a one-day trip plan and save it.</p>
                </div>
            </div>
        </section>

        {{-- ================= CATEGORIES ================= --}}
        @if($categories->count())
            <section class="mt-20 bg-white rounded-3xl border border-gray-100 shadow-sm p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Browse by category</h2>
                <p class="mt-2 text-gray-600">Pick what you enjoy and see the places that match.</p>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    @foreach($categories as $category)
                        <a href="{{ route('home') }}?category={{ $category->id }}"
                           class="px-5 py-2 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ================= CTA ================= --}}
        <section class="mt-16 mb-6 rounded-3xl bg-gray-900 text-white text-center px-6 py-12">
            <h2 class="text-3xl font-bold">Ready for your next day out?</h2>
            <p class="mt-3 text-gray-300">Start exploring and build your one-day plan in minutes.</p>
            <a href="{{ route('trip-plans.create') }}"
               class="mt-6 inline-block bg-emerald-500 hover:bg-emerald-400 text-white font-semibold px-8 py-3 rounded-lg transition-colors">
                Create My Trip Plan
            </a>
        </section>

    </div>
@endsection