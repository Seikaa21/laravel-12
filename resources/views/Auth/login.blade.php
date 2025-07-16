<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-blue-200 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6">🔐 Login</h2>

        @if(session('success'))
            <div class="text-green-600 text-sm mb-3">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="text-red-600 text-sm mb-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded-md bg-gray-100">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-md bg-gray-100">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Login</button>
        </form>

        <div class="text-center mt-4 text-sm">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-semibold">Daftar</a>
        </div>
    </div>
</body>
</html>
