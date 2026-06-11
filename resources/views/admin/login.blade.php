<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Eve Mountain</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Eve Mountain Campsite"
                 class="mx-auto"
                 style="height:70px; width:auto;">
            <p class="text-sm text-gray-500 mt-2">Admin Panel</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7">
            <h2 class="font-semibold text-gray-900 mb-5">Sign in</h2>
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 text-sm mb-4">
                {{ $errors->first() }}
            </div>
            @endif
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded">
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
                <button type="submit"
                        class="w-full bg-green-700 hover:bg-green-800 text-white font-medium py-2.5 rounded-xl text-sm transition-colors">
                    Sign in
                </button>
            </form>
        </div>
        <p class="text-center mt-5 text-xs text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-gray-600">← Back to website</a>
        </p>
    </div>
</body>
</html>
