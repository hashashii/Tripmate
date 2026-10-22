@extends('admin.layout')
@section('title', 'Places')
@section('heading', 'Places')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <form method="GET" class="flex flex-wrap gap-2">
        <input name="search" value="{{ request('search') }}" placeholder="Search name…" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
        <select name="category" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">All categories</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white">Filter</button>
    </form>
    <a href="{{ route('admin.places.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">+ Add place</a>
</div>

<div class="overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
            <tr>
                <th class="px-4 py-3">Place</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Distance</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($places as $place)
                @php
                    $src = $place->image
                        ? (filter_var($place->image, FILTER_VALIDATE_URL) ? $place->image : asset(ltrim($place->image, '/')))
                        : null;
                @endphp
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($src)
                                <img src="{{ $src }}" alt="" loading="lazy" class="h-10 w-14 rounded object-cover">
                            @else
                                <div class="h-10 w-14 rounded bg-gray-200"></div>
                            @endif
                            <div>
                                <span class="font-medium">{{ $place->name }}</span>
                                <div class="text-xs text-gray-500">{{ $place->images_count }} gallery photos</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $place->category->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $place->distance_km }} km</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.places.edit', $place) }}" class="font-medium text-emerald-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.places.destroy', $place) }}" class="ml-3 inline" onsubmit="return confirm('Delete {{ addslashes($place->name) }}?')">
                            @csrf @method('DELETE')
                            <button class="font-medium text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No places found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $places->links() }}</div>
@endsection
