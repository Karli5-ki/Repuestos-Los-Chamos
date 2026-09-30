@extends('layout')

@section('titulo', 'Seguridad y Usuarios - Repuestos Los Chamos')

@section('contenido')
<div class="p-8 max-w-7xl mx-auto w-full">
    
    <!-- Encabezado de la página -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Seguridad y Usuarios</h2>
            <p class="text-gray-500 mt-1 text-sm">Gestión de accesos y bitácora de auditoría del sistema.</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="bg-red-600 text-white px-4 py-2.5 rounded-lg font-bold text-[11px] uppercase tracking-widest shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:bg-red-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Nuevo Usuario
        </a>
    </div>

    <!-- 1. Tarjetas de Resumen (KPIs de Seguridad) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Cuentas Activas</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $cuentasActivas ?? 0 }}</h3>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Cuentas Suspendidas</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $cuentasSuspendidas ?? 0 }}</h3>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4 border-r-4 border-r-red-600">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Usuarios en línea ahora</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $usuariosEnLinea ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- 2. Tabla de Usuarios (Ocupa 2/3 de la pantalla) -->
        <div class="lg:col-span-2 space-y-4">
            
            <!-- Filtros rápidos para el Controlador -->
            <form method="GET" action="{{ route('admin.usuarios.index') }}" class="flex gap-2">
                <button type="submit" name="filtro" value="todos" class="{{ request('filtro') == 'todos' || !request()->has('filtro') ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-500 hover:text-gray-800' }} px-3 py-1.5 rounded text-[10px] font-bold uppercase tracking-widest shadow-sm transition">Todos</button>
                <button type="submit" name="filtro" value="ventas" class="{{ request('filtro') == 'ventas' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-500 hover:text-gray-800' }} px-3 py-1.5 rounded text-[10px] font-bold uppercase tracking-widest transition shadow-sm">Solo Ventas</button>
                <button type="submit" name="filtro" value="almacen" class="{{ request('filtro') == 'almacen' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-500 hover:text-gray-800' }} px-3 py-1.5 rounded text-[10px] font-bold uppercase tracking-widest transition shadow-sm">Solo Almacén</button>
            </form>

            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Empleado / Credenciales</th>
                                <th class="px-6 py-4 font-bold text-center">Rol</th>
                                <th class="px-6 py-4 font-bold text-center">Estado</th>
                                <th class="px-6 py-4 font-bold text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 divide-y divide-gray-100 font-medium">
                            
                            @forelse($usuarios ?? [] as $usuario)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $bgClass = $usuario->rol === 'Admin' ? 'bg-gray-900 text-white' : ($usuario->rol === 'Ventas' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-orange-50 text-orange-700 border border-orange-200');
                                            $iniciales = strtoupper(substr($usuario->nombre, 0, 1) . substr($usuario->apellido ?? '', 0, 1));
                                        @endphp
                                        <div class="w-8 h-8 rounded {{ $bgClass }} flex items-center justify-center text-xs font-bold">
                                            {{ $iniciales }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $usuario->nombre }} {{ $usuario->apellido }}</p>
                                            <p class="text-[10px] text-gray-400 font-mono">{{ $usuario->username ?? $usuario->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="{{ $usuario->rol === 'Admin' ? 'bg-gray-900 text-white' : ($usuario->rol === 'Ventas' ? 'bg-blue-50 text-blue-700 border-blue-200 border' : 'bg-orange-50 text-orange-700 border-orange-200 border') }} px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">
                                        {{ $usuario->rol }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($usuario->estado === 'activo')
                                        <span class="text-green-600 font-bold text-xs">Activo</span>
                                    @else
                                        <span class="text-red-600 font-bold text-xs">Suspendido</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="text-gray-400 hover:text-blue-600 transition mx-1" title="Editar">✏️</a>
                                    
                                    <form action="{{ route('admin.usuarios.logout_force', $usuario->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-orange-600 transition mx-1" title="Forzar Cierre de Sesión">🔌</button>
                                    </form>

                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition mx-1" title="Eliminar">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p class="text-sm font-bold text-gray-700">No se encontraron usuarios</p>
                                    <p class="text-xs text-gray-400 mt-1">Intenta cambiar el filtro o registra un nuevo usuario en el sistema.</p>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Paginación de Laravel -->
            @if(isset($usuarios) && is_object($usuarios) && method_exists($usuarios, 'hasPages') && $usuarios->hasPages())
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
            @endif

        </div>

        <!-- 3. Bitácora de Auditoría (Ocupa 1/3 de la pantalla a la derecha) -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col h-[400px]">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-widest">Bitácora de Auditoría</h3>
                <span class="text-[10px] text-gray-400 font-bold uppercase">Hoy</span>
            </div>
            
            <div class="flex-1 p-6 overflow-y-auto">
                <div class="relative border-l-2 border-gray-100 ml-3 space-y-6">
                    
                    @forelse($bitacora ?? [] as $log)
                        @php
                            $dotColor = match($log->tipo ?? 'sistema') {
                                'facturacion' => 'bg-green-500',
                                'critico' => 'bg-red-500',
                                'sistema' => 'bg-gray-400',
                                'advertencia' => 'bg-orange-500',
                                default => 'bg-blue-500'
                            };
                        @endphp
                        <div class="relative pl-6">
                            <span class="absolute -left-[5px] top-1.5 w-2 h-2 rounded-full {{ $dotColor }} ring-4 ring-white"></span>
                            <p class="text-[10px] font-bold text-gray-400 mb-0.5">{{ $log->created_at ? $log->created_at->diffForHumans() : '' }}</p>
                            <p class="text-sm text-gray-700">{!! $log->mensaje_html !!}</p>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <p class="text-xs font-bold text-gray-600">Sin actividad reciente</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Los eventos del sistema aparecerán aquí.</p>
                        </div>
                    @endforelse

                </div>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50 text-center">
                <a href="{{ route('admin.bitacora.index') }}" class="text-[10px] font-bold text-red-600 hover:text-red-700 uppercase tracking-widest transition">Ver historial completo →</a>
            </div>
        </div>

    </div>
</div>
@endsection