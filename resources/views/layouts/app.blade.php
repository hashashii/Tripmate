<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TripMate - Local Day Trip Planner')</title>
    <script src="https://cdn.tailwindcss.com"></script>

  
    @if(view()->exists('libraries.styles'))
        @include('libraries.styles')
    @endif

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen font-sans">

    {{-- Navigation Bar --}}
    @include('components.nav')


    <main class="flex-grow max-w-screen-2xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>


    @include('components.footer')

   
    @if(view()->exists('libraries.scripts'))
        @include('libraries.scripts')
    @endif

    @stack('scripts')
</body>
</html>