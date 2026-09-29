@props(['place'])


<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border border-gray-100 flex flex-col justify-between">
    <div>
        <div class="relative h-48 w-full bg-gray-200">
            <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
            <span class="absolute top-3 right-3 bg-emerald-600 text-white text-xs font-semibold px-2.5 py-1 rounded-full shadow">
                {{ $place->distance_km }} Km away
            </span>
        </div>
        <div class="p-5">
            <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase">
                {{ $place->category->name ?? 'General' }}
            </span>
            <h3 class="text-xl font-bold text-gray-900 mt-1 mb-2">{{ $place->name }}</h3>
            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                {{ $place->description }}
            </p>
        </div>
    </div>
    <div class="p-5 pt-0">
        <a href="{{ route('places.show', $place->id) }}" class="block text-center w-full bg-gray-900 hover:bg-emerald-600 text-white text-sm font-medium py-2 rounded-lg transition-colors">
            View Spot Details
        </a>
    </div>
</div>