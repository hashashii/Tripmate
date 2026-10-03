@props(['place'])

<div class="flex flex-col justify-between overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md transition-shadow duration-300 hover:shadow-lg">
    <div>
        <div class="relative h-48 w-full bg-gray-200">
            <img
                src="{{ $place->image }}"
                alt="{{ $place->name }}"
                loading="lazy"
                class="h-full w-full object-cover"
            >

            <span class="absolute right-3 top-3 rounded-full bg-emerald-600 px-2.5 py-1 text-xs font-semibold text-white shadow">
                {{ $place->distance_km }} km from home
            </span>
        </div>

        <div class="p-5">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                {{ $place->category->name ?? 'General' }}
            </span>

            <h3 class="mb-2 mt-1 text-xl font-bold text-gray-900">
                {{ $place->name }}
            </h3>

            <p class="line-clamp-3 text-sm text-gray-600">
                {{ $place->description }}
            </p>
        </div>
    </div>

    <div class="space-y-3 p-5 pt-0">
        <a
            href="{{ route('places.show', $place->id) }}"
            class="block w-full rounded-lg bg-gray-900 px-4 py-2.5 text-center text-sm font-medium text-white transition-colors hover:bg-gray-800"
        >
            View Spot Details
        </a>

        @if ($place->distance_km !== null && $place->distance_km <= 25)
            <a
                href="{{ route('trip-plans.create', ['place' => $place->id]) }}"
                class="block w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-center text-sm font-medium text-white transition-colors hover:bg-emerald-700"
            >
                + Add to Trip
            </a>
        @endif
    </div>
</div>