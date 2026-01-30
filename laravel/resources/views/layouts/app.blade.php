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
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#f3f4f6]">
    <div class="flex min-h-screen">
        <!-- Sidebar - Desktop -->
        <aside class="hidden md:flex md:flex-col fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform">
            <!-- Header Sidebar -->
            <div class="px-4 py-6 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
                    <img src="{{ asset('images/quintana-2.jpg') }}" alt="Quintana Energy" class="h-12 w-auto rounded-lg object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display: none;" class="h-12 w-12 rounded-full bg-quintana-green flex items-center justify-center">
                        <span class="text-white font-bold text-xs">QNT</span>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                    Dashboard
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Inventario</p>
                </div>
                @if(!auth()->user()->hasRole('pilot'))
                    <a href="{{ route('production.drones.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                        RPAs
                    </a>
                    <a href="{{ route('production.batteries.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                        Baterías
                    </a>
                    @hasrole('admin')
                        <a href="{{ route('sites.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('sites.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Ubicaciones
                        </a>
                    @endhasrole
                @endif
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Operaciones</p>
                </div>
                @auth
                    @if(!auth()->user()->hasRole('pilot'))
                        <a href="{{ route('production.missions.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Misiones
                        </a>
                    @endif
                    <a href="{{ route('production.wells.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                        Pozos
                    </a>
                    @if(!auth()->user()->hasRole('pilot'))
                        <a href="{{ route('production.logs.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Logs
                        </a>
                    @endif
                @endauth
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Administración</p>
                </div>
                @auth
                    @if(!auth()->user()->hasRole('pilot'))
                        <a href="{{ route('production.users.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.*') && !request()->routeIs('production.users.show') && !request()->routeIs('production.users.edit') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Pilotos
                        </a>
                        <a href="{{ route('providers.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('providers.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Proveedores
                        </a>
                        <a href="{{ route('purchases.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('purchases.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Compras
                        </a>
                    @endif
                    @if(auth()->user()->hasRole('pilot'))
                        @php
                            $authorizedUser = \App\Models\AuthorizedUser::where('web_user_id', auth()->id())->first();
                        @endphp
                        @if($authorizedUser)
                            <a href="{{ route('production.users.show', $authorizedUser) }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.show') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                                Mi Perfil
                            </a>
                        @endif
                        <a href="{{ route('pilot.my-license') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pilot.my-license') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            Mi Licencia
                        </a>
                    @else
                        <a href="{{ route('production.licenses.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Licencias
                        </a>
                    @endif
                    
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.index') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Gestión de Usuarios
                        </a>
                        @php
                            $pendingCount = \App\Models\User::where('is_approved', false)->count();
                        @endphp
                        <a href="{{ route('admin.users.pending') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors relative {{ request()->routeIs('admin.users.pending') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Usuarios Pendientes
                            @if($pendingCount > 0)
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-800">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('security.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('security.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Seguridad
                        </a>
                        <a href="{{ route('software-licenses.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('software-licenses.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Licencias de Software
                        </a>
                        <a href="{{ route('insurances.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('insurances.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Seguros
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
        <div class="flex-1 flex flex-col md:ml-64 min-h-screen bg-[#f3f4f6]">
            <!-- Navbar -->
            <header class="sticky top-0 z-30 bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
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
                            
                            <!-- Dropdown de Usuario -->
                            <div class="relative" x-data="{ open: false }">
                                <button 
                                    @click="open = !open" 
                                    class="flex items-center space-x-2 focus:outline-none"
                                >
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#6b7b39] to-[#5a6830] flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name ?? '', 0, 1)) }}
                                    </div>
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div 
                                    x-show="open" 
                                    @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                    style="display: none;"
                                >
                                    <div class="py-1" role="menu">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                            Mi Perfil
                                        </a>
                                        <form action="{{ route('logout') }}" method="POST" class="block">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                                Cerrar Sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
        <div class="fixed left-0 top-0 bottom-0 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto bg-white border-r border-gray-200">
            <div class="p-4">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-lg font-bold text-gray-900">Menú</span>
                    <button id="close-mobile-menu" class="focus:outline-none text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                        Dashboard
                    </a>
                    @if(!auth()->user()->hasRole('pilot'))
                        <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Inventario</p>
                        </div>
                        <a href="{{ route('production.drones.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.drones.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            RPAs
                        </a>
                        <a href="{{ route('production.batteries.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.batteries.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Baterías
                        </a>
                        <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Operaciones</p>
                        </div>
                        <a href="{{ route('production.missions.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.missions.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Misiones
                        </a>
                        <a href="{{ route('production.wells.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.wells.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Pozos
                        </a>
                        <a href="{{ route('production.logs.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.logs.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Logs
                        </a>
                        <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Administración</p>
                        </div>
                        <a href="{{ route('production.users.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.*') && !request()->routeIs('production.users.show') && !request()->routeIs('production.users.edit') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Pilotos
                        </a>
                        <a href="{{ route('providers.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('providers.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Proveedores
                        </a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('purchases.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Compras
                        </a>
                    @endif
                    @if(auth()->user()->hasRole('pilot'))
                        @php
                            $authorizedUser = \App\Models\AuthorizedUser::where('web_user_id', auth()->id())->first();
                        @endphp
                        @if($authorizedUser)
                            <a href="{{ route('production.users.show', $authorizedUser) }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.users.show') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                                Mi Perfil
                            </a>
                        @endif
                        <a href="{{ route('pilot.my-license') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pilot.my-license') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            Mi Licencia
                        </a>
                    @else
                        <a href="{{ route('production.licenses.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('production.licenses.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                            Licencias
                        </a>
                    @endif
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            @php
                                $pendingCount = \App\Models\User::where('is_approved', false)->count();
                            @endphp
                            <a href="{{ route('admin.users.pending') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors relative {{ request()->routeIs('admin.users.pending') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                                Usuarios Pendientes
                                @if($pendingCount > 0)
                                    <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-800">{{ $pendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('security.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('security.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                                Seguridad
                            </a>
                            <a href="{{ route('software-licenses.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('software-licenses.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                                Licencias de Software
                            </a>
                            <a href="{{ route('insurances.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('insurances.*') ? 'bg-[#6b7b39]/10 text-[#6b7b39] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#6b7b39]' }}">
                                Seguros
                            </a>
                        @endif
                        <div class="border-t border-gray-200 my-2"></div>
                        <form action="{{ route('logout') }}" method="POST" class="px-4">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors text-left">
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
