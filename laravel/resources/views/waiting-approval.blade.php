<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Esperando Validación - Quintana Energy Operations</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color: #0F172A; color: #FFFFFF; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="w-full max-w-2xl px-4">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/qnt-drones-logo.png') }}" alt="QNT DRONES" class="h-24 w-24" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display: none;" class="h-24 w-24 rounded-full bg-gradient-to-b from-[#082032] to-[#1B998B] items-center justify-center">
                    <span class="text-white font-bold text-2xl">QNT</span>
                </div>
            </div>
            <h1 class="text-4xl font-bold mb-4" style="color: #FFFFFF;">Esperando Validación</h1>
            <p class="text-xl" style="color: rgba(255, 255, 255, 0.7);">de Quintana Energy</p>
        </div>

        <div class="rounded-lg p-8 text-center" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 mb-4 animate-spin" style="color: #1B998B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            
            <h2 class="text-2xl font-semibold mb-4" style="color: #FFFFFF;">Tu cuenta está en revisión</h2>
            <p class="text-lg mb-6" style="color: rgba(255, 255, 255, 0.7);">
                Un administrador de Quintana Energy Operations está revisando tu solicitud de acceso.
            </p>
            <p class="text-sm mb-8" style="color: rgba(255, 255, 255, 0.5);">
                Recibirás una notificación por correo electrónico una vez que tu cuenta sea aprobada.
            </p>
            
            <div class="flex justify-center gap-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 rounded-lg font-medium transition-colors" style="background-color: rgba(255, 255, 255, 0.1); color: #FFFFFF;" onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.15)'" onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.1)'">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

