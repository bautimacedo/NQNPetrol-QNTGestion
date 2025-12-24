<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DroneOps Manager') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gray-800 border-b border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-orange-500 hover:text-orange-400 transition-colors">
                            DroneOps Manager
                        </a>
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pilots.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('pilots.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Pilotos
                            </a>
                            <div class="h-6 w-px bg-gray-600"></div>
                            <div class="relative group">
                                <button class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.drones.*', 'production.batteries.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                    Inventario
                                </button>
                                <div class="absolute left-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <a href="{{ route('production.drones.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-orange-400 {{ request()->routeIs('production.drones.*') ? 'bg-gray-700 text-orange-400' : '' }}">
                                        Drones
                                    </a>
                                    <a href="{{ route('production.batteries.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-orange-400 {{ request()->routeIs('production.batteries.*') ? 'bg-gray-700 text-orange-400' : '' }}">
                                        Baterías
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('production.missions.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Misiones
                            </a>
                            <a href="{{ route('production.logs.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Logs
                            </a>
                            <a href="{{ route('production.users.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Usuarios
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-400">NQN Petrol</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>

