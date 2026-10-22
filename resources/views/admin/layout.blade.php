<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') · TripMate Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
@php
    $links = [
        ['admin.dashboard', 'Dashboard', 'admin.dashboard'],
        ['admin.places.index', 'Places', 'admin.places.*'],
        ['admin.categories.index', 'Categories', 'admin.categories.*'],
        ['admin.trip-plans.index', 'Trip Plans', 'admin.trip-plans.*'],
    ];
@endphp
<div class="flex min-h-screen flex-col md:flex-row">
    <aside class="bg-gray-900 text-gray-300 md:w-60 md:shrink-0">
        <div class="flex items-center justify-between px-5 py-4 md:block">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-black text-emerald-400">
                Trip<span class="text-white">Mate</span>
                <span class="ml-1 text-xs font-semibold uppercase text-gray-400">Admin</span>
            </a>
        </div>
        <nav class="flex gap-1 overflow-x-auto px-3 pb-3 md:flex-col md:pb-0">
            @foreach ($links as [$route, $label, $pattern])
                <a href="{{ route($route) }}"
                   class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs($pattern) ? 'bg-emerald-600 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                    {{ $label }}
                </a>
            @endforeach
            <a href="{{ route('home') }}" target="_blank"
               class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-800 hover:text-white">
                View site ↗
            </a>
        </nav>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="flex items-center justify-between border-b border-gray-200 bg-white px-6 py-3">
            <h1 class="text-lg font-bold text-gray-900">@yield('heading', 'Admin')</h1>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-500">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="rounded-lg border border-gray-300 px-3 py-1.5 font-medium text-gray-700 hover:bg-gray-50">
                        Log out
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
