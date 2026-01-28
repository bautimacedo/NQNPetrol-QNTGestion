<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Quintana Energy Operations') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar - Desktop -->
        <aside class="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 md:z-40 bg-gradient-to-b from-zinc-800 to-zinc-900">
            <!-- Header Sidebar -->
            <div class="px-6 py-5 border-b border-zinc-700">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/qnt-drones-logo.png') }}" alt="QNT DRONES" class="h-10 w-10" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display: none;" class="h-10 w-10 rounded-full bg-quintana-green flex items-center justify-center">
                        <span class="text-white font-bold text-xs">QNT</span>
                    </div>
                    <span class="text-white font-semibold text-lg">Quintana Energy</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('pilots.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pilots.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Pilotos
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Inventario</p>
                </div>
                <a href="{{ route('production.drones.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    RPAs
                </a>
                <a href="{{ route('production.batteries.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Baterías
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Operaciones</p>
                </div>
                <a href="{{ route('production.missions.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Misiones
                </a>
                <a href="{{ route('production.wells.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Pozos
                </a>
                <a href="{{ route('providers.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('providers.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Proveedores
                </a>
                <a href="{{ route('purchases.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('purchases.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Compras
                </a>
                <a href="{{ route('production.logs.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Logs
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Administración</p>
                </div>
                <a href="{{ route('production.users.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Usuarios
                </a>
                <a href="{{ route('production.licenses.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                    Licencias
                </a>
                
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        @php
                            $pendingCount = \App\Models\User::where('is_approved', false)->count();
                        @endphp
                        <a href="{{ route('admin.users.pending') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors relative {{ request()->routeIs('admin.users.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                            Usuarios Pendientes
                            @if($pendingCount > 0)
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-amber-500/20 text-amber-400">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('security.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('security.*') ? 'bg-zinc-700 text-white' : 'text-zinc-400 hover:bg-zinc-700/50 hover:text-white' }}">
                            Seguridad
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Footer Sidebar -->
            <div class="px-3 py-4 border-t border-zinc-700">
                @auth
                    <div class="px-4 py-2 text-sm text-zinc-400">
                        <p class="font-medium text-white">{{ auth()->user()->first_name ?? auth()->user()->name }}</p>
                        <p class="text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600/20 hover:bg-red-600/30 rounded-lg transition-colors text-left">
                            Cerrar Sesión
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- Navbar -->
            <header class="sticky top-0 z-30 bg-white shadow-sm border-b">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-500">@yield('page-subtitle', 'Panel de control')</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Botón Hamburguesa Móvil -->
                            <button id="mobile-menu-button" class="md:hidden focus:outline-none text-gray-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm fade-in">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-sm fade-in">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Menú Móvil (Sidebar) -->
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <!-- Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <!-- Sidebar -->
        <div class="fixed left-0 top-0 bottom-0 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto bg-gradient-to-b from-zinc-800 to-zinc-900">
            <div class="p-4">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-lg font-bold text-white">Menú</span>
                    <button id="close-mobile-menu" class="focus:outline-none text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pilots.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pilots.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Pilotos
                    </a>
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Inventario</p>
                    </div>
                    <a href="{{ route('production.drones.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        RPAs
                    </a>
                    <a href="{{ route('production.batteries.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Baterías
                    </a>
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Operaciones</p>
                    </div>
                    <a href="{{ route('production.missions.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Misiones
                    </a>
                    <a href="{{ route('production.wells.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Pozos
                    </a>
                    <a href="{{ route('providers.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('providers.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Proveedores
                    </a>
                    <a href="{{ route('purchases.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('purchases.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Compras
                    </a>
                    <a href="{{ route('production.logs.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Logs
                    </a>
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Administración</p>
                    </div>
                    <a href="{{ route('production.users.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Usuarios
                    </a>
                    <a href="{{ route('production.licenses.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                        Licencias
                    </a>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            @php
                                $pendingCount = \App\Models\User::where('is_approved', false)->count();
                            @endphp
                            <a href="{{ route('admin.users.pending') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors relative {{ request()->routeIs('admin.users.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                                Usuarios Pendientes
                                @if($pendingCount > 0)
                                    <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-amber-500/20 text-amber-400">{{ $pendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('security.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('security.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-700/50 hover:text-white' }}">
                                Seguridad
                            </a>
                        @endif
                        <div class="border-t border-zinc-700 my-2"></div>
                        <form action="{{ route('logout') }}" method="POST" class="px-4">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600/20 hover:bg-red-600/30 rounded-lg transition-colors text-left">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endauth
                </nav>
            </div>
        </div>
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

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', openMobileMenu);
        }
        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
        }
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMobileMenuFunc);
        }

        // Cerrar menú con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
                closeMobileMenuFunc();
            }
        });
    </script>
</body>
</html>
