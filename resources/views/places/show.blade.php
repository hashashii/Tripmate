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