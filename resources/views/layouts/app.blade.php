<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Progress Tugas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @auth
    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js"></script>
    <script src="{{ asset('js/firebase-init.js') }}" defer></script>
    @endauth
</head>

<body class="bg-gray-50">
    @auth
        <div class="min-h-screen flex bg-gray-50">
            <!-- Sidebar (desktop) -->
            <x-sidebar />

            <!-- Content wrapper -->
            <div class="flex-1 flex flex-col min-h-screen">
                <!-- Header -->
                <x-header />

                <!-- Main Content -->
                <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
                    <!-- Page Title (if needed) -->
                    @if(Route::currentRouteName() !== 'tugas.index')
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-gray-900">@yield('page-title', 'Halaman')</h2>
                            @yield('page-subtitle')
                        </div>
                    @endif

                    <!-- Yield Page Content -->
                    @yield('content')
                </main>

                <!-- Footer -->


            </div>
        </div>
    @endauth

    @guest
        <!-- Guest Layout (Login/Register) -->
        <div class="min-h-screen bg-gradient-to-br from-emerald-600 via-teal-600 to-blue-600 flex items-center justify-center p-4">
            <div class="w-full max-w-md">
                @yield('content')
            </div>
        </div>
    @endguest
</body>

</html>
