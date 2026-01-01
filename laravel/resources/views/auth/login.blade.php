<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Quintana Energy Operations</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color: #0F172A; color: #FFFFFF; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/qnt-drones-logo.png') }}" alt="QNT DRONES" class="h-20 w-20" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display: none;" class="h-20 w-20 rounded-full bg-gradient-to-b from-[#082032] to-[#1B998B] items-center justify-center">
                    <span class="text-white font-bold text-xl">QNT</span>
                </div>
            </div>
            <h1 class="text-3xl font-bold mb-2" style="color: #FFFFFF;">Quintana Energy Operations</h1>
            <p class="text-gray-400">Inicia sesión en tu cuenta</p>
        </div>

        <div class="rounded-lg p-8" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg" style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                    <ul class="list-disc list-inside text-sm" style="color: #f87171;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-2" style="color: rgba(255, 255, 255, 0.8);">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-offset-0 transition-colors"
                        style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2); color: #FFFFFF;"
                        onfocus="this.style.borderColor='#1B998B'; this.style.ringColor='#1B998B';"
                        onblur="this.style.borderColor='rgba(255, 255, 255, 0.2)';">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2" style="color: rgba(255, 255, 255, 0.8);">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-offset-0 transition-colors"
                        style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2); color: #FFFFFF;"
                        onfocus="this.style.borderColor='#1B998B'; this.style.ringColor='#1B998B';"
                        onblur="this.style.borderColor='rgba(255, 255, 255, 0.2)';">
                </div>

                <div class="mb-6 flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300"
                        style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);">
                    <label for="remember" class="ml-2 text-sm" style="color: rgba(255, 255, 255, 0.7);">
                        Recordarme
                    </label>
                </div>

                <button type="submit" class="w-full py-3 px-4 rounded-lg font-medium text-white transition-colors qnt-gradient">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm" style="color: rgba(255, 255, 255, 0.6);">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="font-medium transition-colors" style="color: #1B998B;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#1B998B'">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

