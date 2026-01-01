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
<body class="font-sans antialiased" style="background-color: #0F172A; color: #FFFFFF;">
    <div class="min-h-screen" style="background-color: #0F172A;">
        <!-- Navigation -->
        <nav style="background-color: #0F172A; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            <img src="{{ asset('images/qnt-drones-logo.png') }}" alt="QNT DRONES" class="h-10 w-10" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div style="display: none;" class="h-10 w-10 rounded-full bg-gradient-to-b from-[#082032] to-[#1B998B] flex items-center justify-center">
                                <span class="text-white font-bold text-xs">QNT</span>
                            </div>
                        </a>
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold transition-colors" style="color: #FFFFFF;">
                            Quintana Energy Operations
                        </a>
                        <!-- Menú Desktop -->
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pilots.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pilots.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('pilots.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Pilotos
                            </a>
                            <div class="h-6 w-px" style="background-color: rgba(255, 255, 255, 0.2);"></div>
                            <div class="relative group">
                                <button class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.drones.*', 'production.batteries.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.drones.*', 'production.batteries.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                    Inventario
                                </button>
                                <div class="absolute left-0 mt-2 w-48 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50" style="background-color: #0F172A; border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <a href="{{ route('production.drones.index') }}" class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.drones.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                        RPAs
                                    </a>
                                    <a href="{{ route('production.batteries.index') }}" class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.batteries.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                        Baterías
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('production.missions.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.missions.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Misiones
                            </a>
                            <a href="{{ route('production.wells.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.wells.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Pozos
                            </a>
                            <a href="{{ route('production.logs.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.logs.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Logs
                            </a>
                            <a href="{{ route('production.users.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.users.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Usuarios
                            </a>
                            <a href="{{ route('production.licenses.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.licenses.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                Licencias
                            </a>
                            @auth
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.users.pending') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('admin.users.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                        Usuarios Pendientes
                                    </a>
                                    <a href="{{ route('security.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('security.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('security.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                        Seguridad
                                    </a>
                                @endif
                            @endauth
                        </div>
                        <!-- Botón Hamburguesa Móvil -->
                        <button id="mobile-menu-button" class="md:hidden focus:outline-none" style="color: #FFFFFF;">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm hidden sm:inline" style="color: rgba(255, 255, 255, 0.6);">QNT Energy</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menú Móvil (Sidebar) -->
        <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
            <!-- Overlay -->
            <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <!-- Sidebar -->
            <div class="fixed left-0 top-0 bottom-0 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto" style="background-color: #0F172A; border-right: 1px solid rgba(255, 255, 255, 0.1);">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-lg font-bold" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Menú</span>
                        <button id="close-mobile-menu" class="focus:outline-none" style="color: #FFFFFF;">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('pilots.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pilots.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('pilots.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Pilotos
                        </a>
                        <div class="my-2" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
                        <div class="px-4 py-2 text-xs font-semibold uppercase" style="color: rgba(255, 255, 255, 0.5);">Inventario</div>
                        <a href="{{ route('production.drones.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.drones.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            RPAs
                        </a>
                        <a href="{{ route('production.batteries.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.batteries.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Baterías
                        </a>
                        <div class="my-2" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
                        <a href="{{ route('production.missions.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.missions.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Misiones
                        </a>
                        <a href="{{ route('production.wells.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.wells.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Pozos
                        </a>
                        <a href="{{ route('production.logs.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.logs.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Logs
                        </a>
                        <a href="{{ route('production.users.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.users.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Usuarios
                        </a>
                        <a href="{{ route('production.licenses.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('production.licenses.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                            Licencias
                        </a>
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                @php
                                    $pendingCount = \App\Models\User::where('is_approved', false)->count();
                                @endphp
                                <a href="{{ route('admin.users.pending') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors relative {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('admin.users.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                    Usuarios Pendientes
                                    @if($pendingCount > 0)
                                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full" style="background-color: rgba(251, 191, 36, 0.2); color: #fbbf24;">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('security.index') }}" class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('security.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}" style="{{ request()->routeIs('security.*') ? 'background: linear-gradient(135deg, #082032 0%, #1B998B 100%);' : '' }}">
                                    Seguridad
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="background-color: #0F172A;">
            @if(session('success'))
                <div class="mb-6 px-4 py-3 rounded-lg" style="background-color: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #4ade80;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-4 py-3 rounded-lg" style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171;">
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

