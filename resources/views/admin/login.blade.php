<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · TripMate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    <form method="POST" action="{{ route('admin.login.submit') }}"
          class="w-full max-w-sm space-y-4 rounded-2xl bg-white p-8 shadow-lg">
        @csrf
        <div class="text-center">
            <div class="text-2xl font-black text-emerald-600">Trip<span class="text-gray-900">Mate</span></div>
            <p class="mt-1 text-sm text-gray-500">Admin sign in</p>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded"> Remember me
        </label>

        <button class="w-full rounded-lg bg-emerald-600 py-2.5 font-semibold text-white hover:bg-emerald-700">
            Sign in
        </button>
    </form>
</body>
</html>
