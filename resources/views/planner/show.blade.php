@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-12">
        <a
            href="{{ route('trip-plans.index') }}"
            class="text-sm font-semibold text-emerald-700 hover:underline"
        >
            ← My Trip Plans
        </a>

        @if (session('success'))
            <div class="mt-6 rounded-xl bg-emerald-50 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 rounded-2xl bg-emerald-700 p-8 text-white">
            <p class="text-sm font-semibold text-emerald-100">
                YOUR DAY TRIP
            </p>

            <h1 class="mt-2 text-3xl font-bold">
                {{ $plan->plan_name }}
            </h1>

            <p class="mt-3 text-emerald-100">
                {{ $plan->visit_date?->format('d M Y') }}
                · {{ count($plan->selected_places ?? []) }} planned stops
            </p>
        </div>

        <div class="mt-8">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5">
                <h2 class="font-bold text-emerald-900">
                    Starting Point: Our Home
                </h2>

                <p class="mt-1 text-sm text-emerald-800">
                    Each listed distance is measured from our home.
                </p>
            </div>

            <div class="mt-5 space-y-4">
                @forelse ($places as $place)
                    <div class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-700">
                            {{ $loop->iteration }}
                        </span>

                        <div>
                            <h2 class="text-lg font-bold text-gray-900">
                                {{ $place->name }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $place->distance_km }} km from home
                            </p>

                            <a
                                href="{{ route('places.show', $place->id) }}"
                                class="mt-3 inline-block text-sm font-semibold text-emerald-700 hover:underline"
                            >
                                View Place →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="rounded-xl bg-gray-100 p-5 text-gray-600">
                        The places in this plan are no longer available.
                    </p>
                @endforelse
            </div>

            @if ($places->count() < count($plan->selected_places ?? []))
                <p class="mt-4 text-sm text-amber-700">
                    Some places have been removed since this plan was saved.
                </p>
            @endif
        </div>
    </div>
@endsection