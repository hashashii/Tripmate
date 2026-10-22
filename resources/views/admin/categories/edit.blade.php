@extends('admin.layout')
@section('title', 'Edit category')
@section('heading', 'Edit category')

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="max-w-md rounded-xl bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <label class="mb-1 block text-sm font-medium">Name</label>
    <input name="name" value="{{ old('name', $category->name) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    <div class="mt-5 flex gap-3">
        <button class="rounded-lg bg-emerald-600 px-5 py-2.5 font-semibold text-white hover:bg-emerald-700">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
    </div>
</form>
@endsection
