<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-100 to-indigo-200 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6 text-purple-700">🔐 Login</h2>

        @if(session('success'))
            <div class="text-green-600 text-sm mb-3">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="text-red-600 text-sm mb-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <button type="submit"
                    class="w-full bg-purple-600 text-white py-2 rounded-md hover:bg-purple-700 transition-colors">
                Login
            </button>
        </form>

        <div class="text-center mt-4 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-purple-700 font-semibold hover:underline">Daftar</a>
        </div>
    </div>
</body>
</html>
