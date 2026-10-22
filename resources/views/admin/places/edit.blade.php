@extends('admin.layout')
@section('title', 'Edit place')
@section('heading', 'Edit place')

@section('content')
<form method="POST" action="{{ route('admin.places.update', $place) }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl bg-white p-6 shadow-sm">
    @method('PUT')
    @include('admin.places._form')
</form>
@endsection
