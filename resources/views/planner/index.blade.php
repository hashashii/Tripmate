@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-12">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    My Trip Plans
                </h1>

                <p class="mt-2 text-gray-600">
                    Day trips saved in this browser session.
                </p>
            </div>

            <a
                href="{{ route('trip-plans.create') }}"
                class="rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white hover:bg-emerald-700"
            >
                + Create Trip
            </a>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-xl bg-emerald-50 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @forelse ($plans as $plan)
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $plan->plan_name }}
                    </h2>

                    <p class="mt-3 text-gray-600">
                        {{ $plan->visit_date?->format('d M Y') }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ count($plan->selected_places ?? []) }} planned stops
                    </p>

                    <div class="mt-6 flex items-center justify-between gap-4">
                        <a
                            href="{{ route('trip-plans.show', $plan) }}"
                            class="font-semibold text-emerald-700 hover:underline"
                        >
                            View Plan →
                        </a>

                        <form
                            action="{{ route('trip-plans.destroy', $plan) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this trip plan?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="text-sm font-semibold text-red-600 hover:underline"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Your first trip starts here
                    </h2>

                    <p class="mt-3 text-gray-500">
                        Choose local places and save your visit plan.
                    </p>

                    <a
                        href="{{ route('trip-plans.create') }}"
                        class="mt-6 inline-block rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white hover:bg-emerald-700"
                    >
                        Plan a Trip
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection