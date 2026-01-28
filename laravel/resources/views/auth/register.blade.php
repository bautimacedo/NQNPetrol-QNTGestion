<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - Quintana Energy Operations</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen flex">
    <div class="flex w-full min-h-screen">
        <!-- Left Side - Register Form -->
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Register Card -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-2">Crear Cuenta</h1>
                        <p class="text-sm text-gray-600">Completa el formulario para registrarte</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Apellido *</label>
                                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico *</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors"
                                placeholder="tu@email.com">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Nacimiento *</label>
                                <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            </div>

                            <div>
                                <label for="dni" class="block text-sm font-semibold text-gray-700 mb-2">DNI *</label>
                                <input id="dni" type="text" name="dni" value="{{ old('dni') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña *</label>
                                <input id="password" type="password" name="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors"
                                    placeholder="••••••••">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmar Contraseña *</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 px-4 text-sm font-medium text-white rounded-lg transition-colors mb-4" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                            Registrarse
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            ¿Ya tienes cuenta?
                            <a href="{{ route('login') }}" class="font-medium transition-colors" style="color: #6b7b39;" onmouseover="this.style.color='#5a6830'" onmouseout="this.style.color='#6b7b39'">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
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
            </div>
        </div>
    </div>
</body>
</html>
