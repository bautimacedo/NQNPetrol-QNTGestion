<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Quintana Energy Operations</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen flex">
    <div class="flex w-full min-h-screen">
        <!-- Left Side - Login Form -->
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Login Card -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-2">Iniciar Sesión</h1>
                        <p class="text-sm text-gray-600">Ingresa tus credenciales para acceder</p>
                    </div>

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-5">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors"
                                placeholder="tu@email.com">
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                            <input id="password" type="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors"
                                placeholder="••••••••">
                        </div>

                        <div class="mb-6 flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-[#6b7b39] focus:ring-[#6b7b39]">
                            <label for="remember" class="ml-2 text-sm text-gray-700">
                                Recordarme
                            </label>
                        </div>

                        <button type="submit" class="w-full py-3 px-4 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                            Iniciar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8" style="background-color: #6b7b39;">
            <div class="text-center text-white max-w-md">
                <div class="mb-8">
                    <img src="{{ asset('images/qnt-drones-logo.png') }}" alt="QNT DRONES" class="h-24 w-24 mx-auto mb-6" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none;" class="h-24 w-24 rounded-full bg-white/20 items-center justify-center mx-auto mb-6">
                        <span class="text-white font-bold text-2xl">QNT</span>
                    </div>
                    <h2 class="text-3xl font-bold mb-2">Quintana Energy</h2>
                    <p class="text-lg opacity-90">Operations Management System</p>
                </div>
                
                <div class="mt-12 pt-8 border-t border-white/20">
                    <p class="text-white/90 mb-4">¿No tienes cuenta?</p>
                    <a href="{{ route('register') }}" class="inline-block px-6 py-2 text-sm font-medium text-white border-2 border-white rounded-lg hover:bg-white/10 transition-colors">
                        Regístrate
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
