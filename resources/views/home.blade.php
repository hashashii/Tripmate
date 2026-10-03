@extends('layouts.app')

@section('title', 'TripMate - Explore Local Places')

@section('content')
    <div class="space-y-12">

        {{-- Hero --}}
        <section class="relative isolate flex min-h-[520px] items-center overflow-hidden rounded-3xl bg-emerald-950 text-white lg:min-h-[560px]">
            <img
                src="https://images.unsplash.com/photo-1574611122955-5baa61496637?auto=format&fit=crop&w=1920&q=85"
                alt="A train crossing Nine Arch Bridge in Sri Lanka"
                fetchpriority="high"
                class="absolute inset-0 -z-20 h-full w-full object-cover object-[65%_center]"
            >

            <div class="absolute inset-0 -z-10 bg-gradient-to-r from-emerald-950/95 via-emerald-950/65 to-emerald-950/20"></div>

            <div class="w-full px-6 py-12 sm:px-10 sm:py-14 lg:px-14">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-2 text-xs font-semibold tracking-wide">
                        <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                        Small trips. Beautiful memories.
                    </span>

                    <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                        A little adventure,
                        <span class="block text-emerald-300">
                            close to home.
                        </span>
                    </h1>

                    <p class="mt-5 max-w-xl text-base leading-relaxed text-emerald-50 sm:text-lg">
                        Discover local places within 25 km of our home.
                        Pick your favourite spots and make a day of it.
                    </p>

                    <form
                        action="{{ route('home') }}"
                        method="GET"
                        class="mt-7 flex max-w-xl flex-col gap-2 rounded-2xl bg-white p-2 shadow-xl sm:flex-row"
                    >
                        @if (request('category'))
                            <input
                                type="hidden"
                                name="category"
                                value="{{ request('category') }}"
                            >
                        @endif

                        <label for="place-search" class="sr-only">
                            Search places
                        </label>

                        <input
                            id="place-search"
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Where would you like to go?"
                            class="min-w-0 flex-1 rounded-xl px-4 py-3 text-sm text-slate-900 outline-none focus:ring-2 focus:ring-emerald-500"
                        >

                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
                        >
                            Find Places
                        </button>
                    </form>

                    <div class="mt-5 flex flex-wrap items-center gap-4">
                        <a
                            href="{{ route('trip-plans.create') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-amber-300 px-5 py-3 text-sm font-bold text-emerald-950 transition hover:bg-amber-200"
                        >
                            Plan Your Trip
                            <span aria-hidden="true">→</span>
                        </a>

                        <a
                            href="#places"
                            class="rounded-lg px-2 py-3 text-sm font-semibold text-white hover:underline"
                        >
                            Explore Places
                        </a>
                    </div>
                </div>
            </div>
        </section>
        {{-- Categories --}}
        <section>
            <div class="mb-5">
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">
                    Find your kind of adventure
                </p>

                <h2 class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">
                    What would you like to explore?
                </h2>

                <p class="mt-2 text-sm text-slate-600">
                    Choose a category or browse all our local places.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('home', array_filter(
                        ['search' => request('search')],
                        fn ($value) => $value !== null && $value !== ''
                    )) }}"
                    class="rounded-full border px-5 py-2.5 text-sm font-semibold transition
                        {{ !request('category')
                            ? 'border-emerald-600 bg-emerald-600 text-white'
                            : 'border-slate-200 bg-white text-slate-700 hover:border-emerald-500 hover:bg-emerald-50' }}"
                >
                    All Places
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ route('home', array_filter(
                            [
                                'category' => $category->id,
                                'search' => request('search'),
                            ],
                            fn ($value) => $value !== null && $value !== ''
                        )) }}"
                        class="rounded-full border px-5 py-2.5 text-sm font-semibold transition
                            {{ request('category') == $category->id
                                ? 'border-emerald-600 bg-emerald-600 text-white'
                                : 'border-slate-200 bg-white text-slate-700 hover:border-emerald-500 hover:bg-emerald-50' }}"
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Places --}}
        <section id="places" class="scroll-mt-24">
            <div class="mb-6 flex flex-col justify-between gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">
                        Your next day out
                    </p>

                    <h2 class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">
                        Places Close to Home
                    </h2>

                    <p class="mt-2 text-sm text-slate-600">
                        Explore places within 25 km. All distances are from our home.
                    </p>
                </div>

                <span class="self-start rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-800">
                    {{ $places->count() }}
                    {{ $places->count() === 1 ? 'place' : 'places' }} found
                </span>
            </div>

            @if (request('search') || request('category'))
                <div class="mb-6 flex flex-wrap items-center gap-3 rounded-xl bg-slate-50 px-4 py-3">
                    <p class="text-sm text-slate-600">
                        @if (request('search'))
                            Results for “{{ request('search') }}”
                        @else
                            Showing your selected category
                        @endif
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="text-sm font-semibold text-emerald-700 hover:underline"
                    >
                        Clear filters
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($places as $place)
                    <x-place-card :place="$place" />
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                        <h3 class="text-xl font-bold text-slate-900">
                            No places found
                        </h3>

                        <p class="mt-2 text-sm text-slate-600">
                            Try a different place name or browse another category.
                        </p>

                        <a
                            href="{{ route('home') }}"
                            class="mt-5 inline-block rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700"
                        >
                            Browse All Places
                        </a>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Trip Planner --}}
        <section class="rounded-3xl border border-emerald-100 bg-emerald-50 p-6 sm:p-8">
            <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                <div class="max-w-xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">
                        Make a day of it
                    </p>

                    <h2 class="mt-2 text-2xl font-bold text-emerald-950">
                        Found a few places you love?
                    </h2>

                    <p class="mt-3 text-sm leading-relaxed text-emerald-900">
                        Choose your stops, set a date and save your visit order
                        in one simple trip plan.
                    </p>
                </div>

                <a
                    href="{{ route('trip-plans.create') }}"
                    class="inline-flex shrink-0 items-center gap-3 rounded-xl bg-emerald-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800"
                >
                    Create My Trip
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </section>

    </div>
@endsection