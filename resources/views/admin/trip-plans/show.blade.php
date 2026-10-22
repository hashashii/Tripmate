@extends('admin.layout')
@section('title', 'Trip plan')
@section('heading', $plan->plan_name ?? 'Trip plan')

@section('content')
<div class="max-w-2xl rounded-xl bg-white p-6 shadow-sm">
    <p class="text-sm text-gray-500">
        Visit date: <span class="font-medium text-gray-800">{{ optional($plan->visit_date)->format('l, M j, Y') ?? '—' }}</span>
    </p>

    <h2 class="mb-3 mt-5 font-bold">Stops</h2>
    <ol class="space-y-2">
        @forelse ($places as $i => $place)
            <li class="flex items-center gap-3 rounded-lg border border-gray-100 p-3 text-sm">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">{{ $i + 1 }}</span>
                <a href="{{ route('admin.places.edit', $place) }}" class="font-medium hover:text-emerald-600">{{ $place->name }}</a>
                <span class="ml-auto text-gray-500">{{ $place->distance_km }} km</span>
            </li>
        @empty
            <li class="text-sm text-gray-500">No valid stops (places may have been deleted).</li>
        @endforelse
    </ol>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.trip-plans.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50">← Back</a>
        <form method="POST" action="{{ route('admin.trip-plans.destroy', $plan) }}" onsubmit="return confirm('Delete this plan?')">
            @csrf @method('DELETE')
            <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete</button>
        </form>
    </div>
</div>
@endsection
