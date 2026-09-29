@extends('layouts.app')

@section('title', 'TripMate - Explore Local Places')

@section('content')
<div class="space-y-14">

    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-3xl bg-slate-900 text-white">
        <div
            class="absolute inset-0 bg-cover bg-center opacity-40"
            style="background-image: url('https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1600&q=80')"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900/80 to-transparent"></div>

        <div class="relative max-w-3xl px-6 py-16 sm:px-10 sm:py-24">
            <span class="inline-block rounded-full border border-emerald-400/40 bg-emerald-500/20 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-emerald-300">
                Local Day Trips in Sri Lanka
            </span>

            <h1 class="mt-6 text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                Discover places
                <span class="text-emerald-400">close to home.</span>
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-relaxed text-slate-200 sm:text-lg">
                Explore tourist places within 25 km of our starting point.
                Find a place you like and plan a simple one-day visit.
            </p>

            {{-- Search --}}
            <form
                action="{{ route('home') }}"
                method="GET"
                class="mt-8 flex max-w-2xl flex-col gap-3 rounded-2xl bg-white p-2 shadow-xl sm:flex-row"
            >
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search a place, waterfall, beach..."
                    class="min-w-0 flex-1 rounded-xl px-4 py-3 text-sm text-slate-900 outline-none focus:ring-2 focus:ring-emerald-500"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white transition hover:bg-emerald-700"
                >
                    Search Places
                </button>
            </form>
        </div>
    </section>

    {{-- Categories --}}
    <section>
        <div class="mb-6">
            <p class="text-sm font-bold uppercase tracking-widest text-emerald-700">
                Explore by interest
            </p>
            <h2 class="mt-1 text-3xl font-black text-slate-900">
                Categories
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                Choose the type of place you would like to visit.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('home', array_filter(['search' => request('search')])) }}"
                class="rounded-full px-5 py-2.5 text-sm font-semibold transition
                    {{ !request('category')
                        ? 'bg-emerald-600 text-white'
                        : 'border border-slate-200 bg-white text-slate-700 hover:border-emerald-500' }}"
            >
                All Places
            </a>

            @foreach($categories as $category)
                <a
                    href="{{ route('home', array_filter([
                        'category' => $category->id,
                        'search' => request('search')
                    ])) }}"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition
                        {{ request('category') == $category->id
                            ? 'bg-emerald-600 text-white'
                            : 'border border-slate-200 bg-white text-slate-700 hover:border-emerald-500' }}"
                >
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Places --}}
    <section>
        <div class="mb-6 flex flex-col justify-between gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-emerald-700">
                    Day-trip ideas
                </p>
                <h2 class="mt-1 text-3xl font-black text-slate-900">
                    Places Within 25 km
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    Distances are measured from our fixed starting point.
                </p>
            </div>

            <span class="self-start rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800">
                {{ $places->count() }} {{ $places->count() === 1 ? 'place' : 'places' }}
            </span>
        </div>

        @if(request('search') || request('category'))
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <p class="text-sm text-slate-600">
                    Showing filtered results
                </p>
                <a
                    href="{{ route('home') }}"
                    class="text-sm font-semibold text-emerald-700 hover:underline"
                >
                    Clear filters
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($places as $place)
                <x-place-card :place="$place" />
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                    <h3 class="text-xl font-bold text-slate-900">
                        No places found
                    </h3>
                    <p class="mt-2 text-sm text-slate-600">
                        Try another search or choose a different category.
                    </p>
                    <a
                        href="{{ route('home') }}"
                        class="mt-5 inline-block rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700"
                    >
                        View All Places
                    </a>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection