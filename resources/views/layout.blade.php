<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema') - Repuestos Los Chamos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800 font-sans selection:bg-red-600 selection:text-white">

    <!-- Menú Lateral (Sidebar) -->
    <aside class="w-64 bg-black text-white flex flex-col h-screen border-r border-gray-900 z-20 shrink-0">
        
        <!-- Cabecera del Menú con Logo -->
        <div class="h-20 flex items-center justify-center border-b border-red-600 shrink-0 gap-3 px-4 bg-black">
            <!-- Asume que tienes el logo en public/logo.png -->
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-[0_0_8px_rgba(220,38,38,0.5)]">
            <h1 class="text-sm font-bold text-white uppercase tracking-wider leading-tight">
                Los Chamos <br>
                <span class="text-red-500 text-xs tracking-widest">
                    @if(request()->routeIs('almacen.*') || request()->is('almacen*')) ALMACÉN 
                    @elseif(request()->routeIs('ventas.*') || request()->is('ventas*')) VENTAS 
                    @else DIESEL @endif
                </span>
            </h1>
        </div>
        
        <!-- Opciones de Navegación -->
        <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto">
            
            @if(request()->routeIs('almacen.*') || request()->is('almacen*'))
                <!-- ================= SIDEBAR ALMACÉN ================= -->
                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Principal</p>
                    <div class="space-y-1">
                        <a href="{{ route('almacen.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('almacen.dashboard') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Panel de Control</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Logística</p>
                    <div class="space-y-1">
                        <a href="{{ route('almacen.inventario.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('almacen.inventario.*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Inventario</span>
                        </a>
                        <a href="{{ route('almacen.catalogo') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('almacen.catalogo*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Catálogo</span>
                        </a>
                    </div>
                </div>

            @elseif(request()->routeIs('ventas.*') || request()->is('ventas*'))
                <!-- ================= SIDEBAR VENTAS (CORREGIDO Y AJUSTADO A TUS RUTAS) ================== -->
                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Mi Espacio</p>
                    <div class="space-y-1">
                        <a href="{{ route('ventas.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('ventas.dashboard') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Panel Comercial</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Operaciones</p>
                    <div class="space-y-1">
                        <a href="{{ route('ventas.cotizacion') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('ventas.cotizacion') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Nueva Cotización</span>
                        </a>
                        <a href="{{ route('ventas.facturacion') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('ventas.facturacion*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Facturación (POS)</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Consultas</p>
                    <div class="space-y-1">
                        <a href="{{ route('ventas.inventario.consulta') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('ventas.inventario.consulta') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Buscar Repuestos</span>
                        </a>
                        <a href="{{ route('ventas.catalogo') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('ventas.catalogo*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Catálogo Visual</span>
                        </a>
                    </div>
                </div>

            @else
                <!-- ================= SIDEBAR ADMINISTRACIÓN ========== -->
                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Principal</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Panel de Control</span>
                        </a>
                        <a href="{{ route('admin.facturacion.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.facturacion*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Facturación</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Logística</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.inventario.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.inventario.*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Gestión Inventario</span>
                        </a>
                        <a href="{{ route('admin.catalogo') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.catalogo*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Admin. Catálogo</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Configuración</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.usuarios.*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Usuarios y Roles</span>
                        </a>
                        <a href="{{ route('admin.proveedores.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.proveedores.*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            <span class="text-sm font-medium tracking-wide">Proveedores</span>
                        </a>
                    </div>
                </div>
            @endif

        </nav>
        
        <!-- Info del Usuario Logueado (Fija abajo) -->
        <div class="p-4 border-t border-gray-900 bg-black shrink-0">
            @auth
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-sm shadow-[0_0_8px_rgba(220,38,38,0.4)] uppercase">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Usuario' }}</p>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest truncate">
                        @if(request()->routeIs('almacen.*') || request()->is('almacen*')) ALMACÉN 
                        @elseif(request()->routeIs('ventas.*') || request()->is('ventas*')) VENTAS 
                        @else ADMIN @endif
                    </p>
                </div>
            </div>
            @endauth
        </div>
    </aside>

    <!-- Contenedor Principal -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-50">
        
        <!-- Barra superior -->
        <header class="h-20 flex items-center px-8 justify-between shrink-0 border-b border-gray-200 bg-white sticky top-0 z-10">
            <div class="relative w-full max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" placeholder="Búsqueda rápida en el sistema (Ctrl+K)..." class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-transparent rounded-lg text-sm text-gray-700 placeholder-gray-500 focus:bg-white focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition">
            </div>
            
            <div class="flex items-center gap-6 ml-auto">
                <!-- Icono Notificaciones -->
                <button class="relative text-gray-400 hover:text-gray-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white"></span>
                </button>
                
                <!-- Botón Salir -->
                <div class="pl-6 border-l border-gray-200">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[11px] font-bold text-gray-400 uppercase tracking-widest hover:text-red-600 transition flex items-center gap-2">
                            Salir
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Contenido Dinámico -->
        <div id="contenido-dinamico" class="p-6 md:p-8 flex-1 flex flex-col">
            @yield('contenido')
        </div>
        
    </main>
</body>
</html>