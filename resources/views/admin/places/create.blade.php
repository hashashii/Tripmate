@extends('admin.layout')
@section('title', 'Add place')
@section('heading', 'Add place')

@section('content')
<form method="POST" action="{{ route('admin.places.store') }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl bg-white p-6 shadow-sm">
    @include('admin.places._form')
</form>
@endsection
