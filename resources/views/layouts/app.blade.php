<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/js/app.js')
</head>
<body class="p-8">
    <header>
        <h1 class="text-2xl font-bold">Ticketing System</h1>

        <nav class="mt-4">

            <a href="{{ route('tickets.index') }}" class="text-blue-600 mr-4">Tickets</a>

            <a href="{{ route('replies.index') }}" class="text-blue-600 mr-4">Replies</a>

            <span class="mr-4">User: {{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf

                <button type="submit" class="border p-2">Logout</button>
            </form>
        </nav>
    </header>

    <hr class="my-6">

    @if (session('success'))
        <p class="border border-green-600 bg-green-100 p-2 mb-4">
            {{ session('success') }}
        </p>
    @endif

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
