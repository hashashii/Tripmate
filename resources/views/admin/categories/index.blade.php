@extends('admin.layout')
@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="overflow-x-auto rounded-xl bg-white shadow-sm lg:col-span-2">
        <table class="w-full text-left text-sm">
            <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Places</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $c)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $c->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $c->places_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.categories.edit', $c) }}" class="font-medium text-emerald-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="ml-3 inline" onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button class="font-medium text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="h-fit rounded-xl bg-white p-5 shadow-sm">
        @csrf
        <h2 class="mb-3 font-bold">New category</h2>
        <input name="name" value="{{ old('name') }}" placeholder="Category name" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        <button class="mt-3 w-full rounded-lg bg-emerald-600 py-2 font-semibold text-white hover:bg-emerald-700">Add</button>
    </form>
</div>
@endsection
