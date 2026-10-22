@extends('layouts.app')

@php
    $hasLocation =
        is_numeric($place->latitude) &&
        is_numeric($place->longitude);

    if ($hasLocation) {
        $lat = (float) $place->latitude;
        $lon = (float) $place->longitude;

        $bbox = implode(',', [
            $lon - 0.01,
            $lat - 0.01,
            $lon + 0.01,
            $lat + 0.01,
        ]);
    }

    $imageUrl = $place->image
        ? (filter_var($place->image, FILTER_VALIDATE_URL)
            ? $place->image
            : asset(ltrim($place->image, '/')))
        : null;
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Back button --}}
    <a
        href="{{ route('home') }}"
        class="inline-block mb-6 text-sm font-medium text-gray-500 hover:text-emerald-600"
    >
        ← Back to Places
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Place image --}}
            <div class="h-72 sm:h-96 overflow-hidden rounded-2xl bg-gray-200 shadow-sm">
                @if($imageUrl)
                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $place->name }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                        Image not available
                    </div>
                @endif
            </div>

            {{-- Photo gallery --}}
            @if($place->images->count())
                <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Photo Gallery</h2>
                        <span class="text-xs font-semibold text-gray-500">{{ $place->images->count() }} photos</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($place->images as $photo)
                            <button
                                type="button"
                                data-gallery-item
                                data-index="{{ $loop->index }}"
                                data-src="{{ $photo->url }}"
                                class="group relative aspect-[4/3] overflow-hidden rounded-xl bg-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                                <img
                                    src="{{ $photo->url }}"
                                    alt="{{ $place->name }} photo {{ $loop->iteration }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                >
                                <span class="absolute inset-0 bg-black/0 transition-colors group-hover:bg-black/20"></span>
                            </button>
                        @endforeach
                    </div>
                </section>

                {{-- Lightbox --}}
                <div id="gallery-lightbox" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/90 p-4">
                    <button type="button" id="lb-close" class="absolute right-4 top-4 text-4xl leading-none text-white/80 hover:text-white" aria-label="Close">&times;</button>
                    <button type="button" id="lb-prev" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/10 px-4 py-3 text-2xl text-white hover:bg-white/20" aria-label="Previous">&#8249;</button>
                    <img id="lb-img" src="" alt="" class="max-h-[85vh] max-w-full rounded-lg object-contain shadow-2xl">
                    <button type="button" id="lb-next" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/10 px-4 py-3 text-2xl text-white hover:bg-white/20" aria-label="Next">&#8250;</button>
                    <span id="lb-count" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-sm text-white/80"></span>
                </div>

                @push('scripts')
                <script>
                    (function () {
                        var items = Array.from(document.querySelectorAll('[data-gallery-item]'));
                        var box = document.getElementById('gallery-lightbox');
                        var img = document.getElementById('lb-img');
                        var count = document.getElementById('lb-count');
                        var current = 0;

                        function show(i) {
                            current = (i + items.length) % items.length;
                            img.src = items[current].dataset.src;
                            count.textContent = (current + 1) + ' / ' + items.length;
                        }
                        function open(i) {
                            show(i);
                            box.classList.remove('hidden');
                            box.classList.add('flex');
                            document.body.style.overflow = 'hidden';
                        }
                        function close() {
                            box.classList.add('hidden');
                            box.classList.remove('flex');
                            document.body.style.overflow = '';
                        }

                        items.forEach(function (el, i) { el.addEventListener('click', function () { open(i); }); });
                        document.getElementById('lb-close').addEventListener('click', close);
                        document.getElementById('lb-prev').addEventListener('click', function () { show(current - 1); });
                        document.getElementById('lb-next').addEventListener('click', function () { show(current + 1); });
                        box.addEventListener('click', function (e) { if (e.target === box) close(); });
                        document.addEventListener('keydown', function (e) {
                            if (box.classList.contains('hidden')) return;
                            if (e.key === 'Escape') close();
                            if (e.key === 'ArrowLeft') show(current - 1);
                            if (e.key === 'ArrowRight') show(current + 1);
                        });
                    })();
                </script>
                @endpush
            @endif

            {{-- Place description --}}
            <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <span class="inline-block mb-3 px-3 py-1 rounded-md bg-emerald-50 text-emerald-600 text-xs font-semibold uppercase">
                    {{ $place->category->name ?? 'General' }}
                </span>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-4">
                    {{ $place->name }}
                </h1>

                <h2 class="text-lg font-bold text-gray-800 mb-2">
                    About this Spot
                </h2>

                <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                    {{ $place->description }}
                </p>
            </section>

            {{-- Facilities and safety information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">
                        Facilities
                    </h2>

                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $place->facilities ?: 'Facilities information is not available yet.' }}
                    </p>
                </section>

                <section class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-200">
                    <h2 class="text-lg font-bold text-amber-900 mb-3">
                        Safety &amp; Visitor Guidance
                    </h2>

                    <p class="text-amber-950 leading-relaxed whitespace-pre-line">
                        {{ $place->safety_info ?: 'Please check local conditions before visiting.' }}
                    </p>
                </section>
            </div>

            {{-- Extra information for visitors --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Opening hours --}}
                <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Opening Hours</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $place->opening_hours ?: 'Opening hours are not available yet.' }}
                    </p>
                </section>

                {{-- Entrance fee --}}
                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">

                        <div>
                            <h2 class="text-xl font-bold tracking-tight text-gray-900">
                                Entrance Fee
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Ticket prices & admission details
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-green-100 bg-green-50 p-5">
                        <p class="inline-flex items-center rounded-full bg-green-100 px-4 py-1.5 text-sm font-bold tracking-wide text-green-700 ring-1 ring-inset ring-green-200">
                            {{ $place->entrance_fee ?: 'Entrance fee information is not available yet.' }}
                        </p>
                    </div>
                </section>

                {{-- Accessibility information --}}
                <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Accessibility</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $place->accessibility ?: 'Accessibility information is not available yet.' }}
                    </p>
                </section>

                {{-- Helpful travel tips --}}
                <section class="bg-emerald-50 rounded-2xl p-6 shadow-sm border border-emerald-100">
                    <h2 class="text-lg font-bold text-emerald-900 mb-3">Travel Tips</h2>
                    <p class="text-emerald-950 leading-relaxed whitespace-pre-line">
                        {{ $place->travel_tips ?: 'Travel tips are not available yet.' }}
                    </p>
                </section>
                    </div>

            {{-- Map --}}
            <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    Place Location
                </h2>

                @if($hasLocation)
                    <div class="w-full h-96 overflow-hidden rounded-xl border border-gray-200">
                        <iframe
                            class="w-full h-full border-0"
                            loading="lazy"
                            title="Location of {{ $place->name }}"
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ urlencode($bbox) }}&amp;layer=mapnik&amp;marker={{ $lat }}%2C{{ $lon }}"
                        ></iframe>
                    </div>

                    <a
                        href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lon }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-block mt-4 text-sm font-semibold text-emerald-600 hover:underline"
                    >
                        Open directions in Google Maps ↗
                    </a>
                @else
                    <p class="text-gray-500">
                        Map location is not available yet.
                    </p>
                @endif
            </section>
        </div>

        {{-- Quick information sidebar --}}
        <aside>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:sticky lg:top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">
                    Quick Information
                </h3>

                <p class="text-xs text-gray-500 font-medium mb-1">
                    Distance from starting point
                </p>

                <p class="text-lg font-bold text-emerald-700">
                    {{ $place->distance_km }} km
                </p>

                @if($hasLocation)
                    <a
                        href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lon }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="block w-full mt-6 text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 rounded-xl"
                    >
                        Start Navigation
                    </a>
                @endif
            </div>
        </aside>

    </div>
</div>
@endsection