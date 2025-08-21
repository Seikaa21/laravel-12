<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        {{-- Navbar --}}
        <nav class="mb-6 bg-white shadow rounded-lg p-4 flex justify-between">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <div>
                <a href="{{ route('welcome') }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg">Home</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg">Logout</button>
                </form>
            </div>
        </nav>

        {{-- Konten --}}
        <div class="bg-white shadow rounded-lg p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
