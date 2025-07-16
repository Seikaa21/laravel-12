<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Project Alfath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #a7c7ff, #d0bfff);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="text-center text-white p-10 max-w-md w-full bg-white/10 backdrop-blur-md rounded-2xl shadow-xl">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang</h1>
        <p class="mb-8 text-sm">Silakan masuk atau daftar untuk melanjutkan ke aplikasi.</p>

        <div class="flex justify-center gap-6">
            <a href="{{ route('login') }}" class="bg-blue-400 hover:bg-blue-500 text-white text-lg px-8 py-4 rounded-full transition duration-300">Login</a>
            <a href="{{ route('register') }}" class="bg-purple-400 hover:bg-purple-500 text-white text-lg px-8 py-4 rounded-full transition duration-300">Register</a>
        </div>
    </div>

</body>
</html>
