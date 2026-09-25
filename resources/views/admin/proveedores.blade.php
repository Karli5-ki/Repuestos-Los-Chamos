<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores - Repuestos Los Chamos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800 font-sans selection:bg-red-600 selection:text-white">

    <!-- MENÚ LATERAL (SIDEBAR) -->
    <aside class="w-64 bg-black text-white flex flex-col h-screen overflow-y-auto border-r border-gray-900 z-20 shrink-0">
        <div class="h-20 flex items-center justify-center border-b border-red-600 shrink-0 gap-3 px-4 bg-black">
            <!-- Uso del helper asset() para imágenes públicas -->
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-[0_0_8px_rgba(220,38,38,0.5)]">
            <h1 class="text-sm font-bold text-white uppercase tracking-wider leading-tight">
                Los Chamos <br><span class="text-red-500 text-xs tracking-widest">Diesel</span>
            </h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-6">
            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Principal</p>
                <div class="space-y-1">
                   <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 ...">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="text-sm font-medium tracking-wide">Panel de Control</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Mostrador</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.facturacion.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-medium tracking-wide">Facturación</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Logística</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.inventario.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <span class="text-sm font-medium tracking-wide">Gestión Inventario</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Configuración</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-sm font-medium tracking-wide">Usuarios y Roles</span>
                    </a>
                    <!-- BOTÓN ACTIVO -->
                    <a href="{{ route('admin.proveedores.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-red-600 text-white font-bold shadow-[0_4px_10px_rgba(220,38,38,0.3)] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        <span class="text-sm tracking-wide">Proveedores</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Datos del usuario autenticado -->
        <div class="p-4 border-t border-gray-900 bg-gray-950">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-sm shadow-[0_0_8px_rgba(220,38,38,0.4)]">
                    {{ strtoupper(substr(auth()->user()->name ?? 'C', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-white">{{ auth()->user()->name ?? 'Carlos Admin' }}</p>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ auth()->user()->role ?? 'Administrador' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-50">
        
        <header class="h-20 flex items-center px-8 justify-between shrink-0 border-b border-gray-200 bg-white sticky top-0 z-10">
            <div class="relative w-full max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" placeholder="Búsqueda rápida en el sistema (Ctrl+K)..." class="w-full pl-10 pr-4 py-2.5 bg-gray-100/50 border border-transparent rounded-lg text-sm text-gray-700 placeholder-gray-500 focus:bg-white focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition">
            </div>
            
            <div class="flex items-center gap-6 ml-auto">
                <button class="relative text-gray-400 hover:text-gray-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white"></span>
                </button>
                
                <div class="pl-6 border-l border-gray-200">
                    <!-- Formulario de Logout (Laravel estándar) -->
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

        <!-- CONTENIDO DEL MÓDULO: PROVEEDORES -->
        <div class="p-8 max-w-7xl mx-auto w-full">
            
            <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Directorio de Proveedores</h2>
                    <p class="text-gray-500 mt-1 text-sm">Gestiona los distribuidores, mayoristas y contactos comerciales.</p>
                </div>
                <a href="{{ route('admin.proveedores.create') }}" class="bg-red-600 text-white px-4 py-2.5 rounded-lg font-bold text-[11px] uppercase tracking-widest shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:bg-red-700 hover:-translate-y-0.5 transition-all flex items-center gap-2 w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Nuevo Proveedor
                </a>
            </div>

            <!-- Tarjetas de Resumen (Variables dinámicas) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-5 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gray-900 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Empresas Registradas</p>
                        <h3 class="text-2xl font-black text-gray-800">{{ $totalProveedores ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Proveedores Activos</p>
                        <h3 class="text-2xl font-black text-gray-800">{{ $proveedoresActivos ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Pedidos en Tránsito</p>
                        <h3 class="text-2xl font-black text-gray-800">{{ $pedidosTransito ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Tabla de Proveedores -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
                
                <!-- Buscador Formulario GET -->
                <form method="GET" action="{{ route('admin.proveedores.index') }}" class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row gap-4 items-center justify-between gap-4">
                    <div class="relative w-full sm:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por Razón Social, RIF o Contacto..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-md text-sm text-gray-800 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm">
                    </div>
                    <!-- Botón oculto para enviar al presionar Enter -->
                    <button type="submit" class="hidden"></button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-white text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Empresa (Razón Social)</th>
                                <th class="px-6 py-4 font-bold">Vendedor / Contacto</th>
                                <th class="px-6 py-4 font-bold text-center">Especialidad</th>
                                <th class="px-6 py-4 font-bold text-right">Contacto</th>
                                <th class="px-6 py-4 font-bold text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 divide-y divide-gray-100 font-medium">
                            
                            @forelse($proveedores as $proveedor)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 font-bold text-xs uppercase">
                                            {{ substr($proveedor->razon_social, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $proveedor->razon_social }}</p>
                                            <p class="text-[11px] text-gray-500 font-mono mt-0.5">{{ $proveedor->rif }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800 font-bold">{{ $proveedor->contacto_nombre }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase">{{ $proveedor->contacto_cargo ?? 'Ventas' }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-md text-[10px] font-bold uppercase tracking-widest border border-gray-200">{{ $proveedor->especialidad }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="font-mono text-sm text-gray-900">{{ $proveedor->telefono }}</p>
                                    <p class="text-[10px] text-blue-600 hover:underline cursor-pointer">{{ $proveedor->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-center opacity-0 group-hover:opacity-100 transition-opacity flex justify-center items-center gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="text-gray-400 hover:text-blue-600 transition" title="Editar">
                                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <!-- Botón Eliminar con Formulario de Laravel -->
                                    <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Eliminar">
                                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No se encontraron proveedores registrados.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación de Laravel (Soporta Tailwind por defecto) -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                   @if(is_object($proveedores) && method_exists($proveedores, 'links'))
    {{ $proveedores->links() }}
@endif
                </div>

            </div>
        </div>
        
    </main>
</body>
</html>