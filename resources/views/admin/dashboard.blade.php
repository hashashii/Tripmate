@extends('admin.layout')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')

{{-- Dashboard Statistics --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

    @foreach ([
        ['Places', $stats['places'], 'admin.places.index', 'Total places available'],
        ['Categories', $stats['categories'], 'admin.categories.index', 'Organized place categories'],
        ['Trip Plans', $stats['plans'], 'admin.trip-plans.index', 'Plans created by users'],
    ] as [$label, $count, $route, $description])

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        {{ $label }}
                    </p>

                    <p class="mt-3 text-4xl font-extrabold tracking-tight text-gray-900">
                        {{ $count }}
                    </p>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    @if ($label === 'Places')
                        <span class="text-2xl">📍</span>
                    @elseif ($label === 'Categories')
                        <span class="text-2xl">🗂️</span>
                    @else
                        <span class="text-2xl">🧭</span>
                    @endif
                </div>
            </div>

            <p class="mt-3 text-sm text-gray-500">
                {{ $description }}
            </p>

            <div class="mt-5 border-t border-gray-100 pt-4">
                <a href="{{ route($route) }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 transition hover:text-emerald-900">
                    Manage {{ $label }}
                    <span>→</span>
                </a>
            </div>

        </div>

    @endforeach

</div>


{{-- Dashboard Details --}}
<div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-3">

    {{-- Places per Category --}}
    <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-gray-900">
                Places per Category
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Number of places in each category
            </p>
        </div>

        <ul class="divide-y divide-gray-100 text-sm">
            @forelse ($categories as $c)
                <li class="flex items-center justify-between gap-3 py-4">

                    <span class="font-medium text-gray-700">
                        {{ $c->name }}
                    </span>

                    <span class="rounded-lg bg-emerald-50 px-3 py-1 font-bold text-emerald-700">
                        {{ $c->places_count }}
                    </span>

                </li>
            @empty
                <li class="py-4 text-sm text-gray-500">
                    No categories yet.
                </li>
            @endforelse
        </ul>

    </section>


    {{-- Recent Places --}}
    <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

        <div class="mb-5 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Recent Places
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Recently added destinations
                </p>
            </div>

        </div>

        <ul class="divide-y divide-gray-100 text-sm">
            @forelse ($recentPlaces as $p)
                <li class="py-4">

                    <a href="{{ route('admin.places.edit', $p) }}"
                       class="font-semibold text-gray-800 transition hover:text-emerald-700">
                        {{ $p->name }}
                    </a>

                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                        <span>{{ $p->category->name ?? '—' }}</span>
                        <span>·</span>
                        <span>{{ $p->distance_km }} km</span>
                    </div>

                </li>
            @empty
                <li class="py-4 text-gray-500">
                    No places yet.
                </li>
            @endforelse
        </ul>

    </section>


    {{-- Recent Trip Plans --}}
    <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-gray-900">
                Recent Trip Plans
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Recently created travel plans
            </p>
        </div>

        <ul class="divide-y divide-gray-100 text-sm">
            @forelse ($recentPlans as $plan)
                <li class="py-4">

                    <a href="{{ route('admin.trip-plans.show', $plan) }}"
                       class="font-semibold text-gray-800 transition hover:text-emerald-700">
                        {{ $plan->plan_name ?? 'Untitled' }}
                    </a>

                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                        <span>
                            {{ optional($plan->visit_date)->format('M j, Y') ?? 'No date' }}
                        </span>
                        <span>·</span>
                        <span>
                            {{ count($plan->selected_places ?? []) }} stops
                        </span>
                    </div>

                </li>
            @empty
                <li class="py-4 text-gray-500">
                    No trip plans yet.
                </li>
            @endforelse
        </ul>

    </section>

</div>

@endsection
