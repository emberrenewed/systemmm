<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/js/app.js')
</head>
<body class="p-8">
    <h1 class="text-2xl font-bold">Admin Login</h1>

    <form method="POST" action="{{ route('login') }}" class="max-w-sm mt-6">
        @csrf

        <label for="email">Email  -  admin@test.com</label>

        <input id="email" type="email" name="email" value="{{ old('email') }}" class="block w-full border p-2 mb-2" required>

        @error('email')<p class="text-red-600">{{ $message }}</p>@enderror

        <label for="password" class="block mt-4">Password</label>

        <input
            id="password" type="password" name="password" class="block w-full border p-2 mb-2" required>
        @error('password')<p class="text-red-600">{{ $message }}</p>@enderror
        <button type="submit" class="bg-black text-white p-2 mt-4">Login</button>
    </form>
</body>
</html>
