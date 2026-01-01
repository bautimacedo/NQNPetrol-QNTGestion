<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Quintana Energy Operations') }} - Dashboard</title>

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
                            Quintana Energy Operations
                        </a>
                        <!-- Menú Desktop -->
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
                                        RPAs
                                    </a>
                                    <a href="{{ route('production.batteries.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-orange-400 {{ request()->routeIs('production.batteries.*') ? 'bg-gray-700 text-orange-400' : '' }}">
                                        Baterías
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('production.missions.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Misiones
                            </a>
                            <a href="{{ route('production.wells.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Pozos
                            </a>
                            <a href="{{ route('production.logs.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Logs
                            </a>
                            <a href="{{ route('production.users.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Usuarios
                            </a>
                            <a href="{{ route('production.licenses.index') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                                Licencias
                            </a>
                        </div>
                        <!-- Botón Hamburguesa Móvil -->
                        <button id="mobile-menu-button" class="md:hidden text-gray-300 hover:text-orange-400 focus:outline-none focus:text-orange-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-400 hidden sm:inline">NQN Petrol</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menú Móvil (Sidebar) -->
        <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
            <!-- Overlay -->
            <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <!-- Sidebar -->
            <div class="fixed left-0 top-0 bottom-0 w-64 bg-gray-800 border-r border-gray-700 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-lg font-bold text-orange-500">Menú</span>
                        <button id="close-mobile-menu" class="text-gray-300 hover:text-orange-400 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('pilots.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('pilots.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Pilotos
                        </a>
                        <div class="border-t border-gray-700 my-2"></div>
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Inventario</div>
                        <a href="{{ route('production.drones.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            RPAs
                        </a>
                        <a href="{{ route('production.batteries.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Baterías
                        </a>
                        <div class="border-t border-gray-700 my-2"></div>
                        <a href="{{ route('production.missions.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Misiones
                        </a>
                        <a href="{{ route('production.wells.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Pozos
                        </a>
                        <a href="{{ route('production.logs.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Logs
                        </a>
                        <a href="{{ route('production.users.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Usuarios
                        </a>
                        <a href="{{ route('production.licenses.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-300 hover:text-orange-400 hover:bg-gray-700 rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'text-orange-400 bg-gray-700' : '' }}">
                            Licencias
                        </a>
                    </nav>
                </div>
            </div>
        </div>

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

    <script>
        // Control del menú móvil
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenu = document.getElementById('close-mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const sidebar = mobileMenu.querySelector('.fixed.left-0');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        function openMobileMenu() {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                sidebar.classList.remove('-translate-x-full');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            }, 10);
        }

        function closeMobileMenuFunc() {
            sidebar.classList.add('-translate-x-full');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        }

        mobileMenuButton.addEventListener('click', openMobileMenu);
        closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
        mobileMenuOverlay.addEventListener('click', closeMobileMenuFunc);

        // Cerrar menú con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                closeMobileMenuFunc();
            }
        });
    </script>
</body>
</html>

