@extends('layout')

@section('titulo', 'Nueva Cotización - Repuestos Los Chamos')

@section('contenido')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { 
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
        opacity: 0; 
    }
</style>

<!-- CONTENEDOR PRINCIPAL DEL MÓDULO (Split Screen) -->
<div class="flex-1 flex overflow-hidden h-full">
    
    <!-- LADO IZQUIERDO: Buscador de Repuestos -->
    <div class="flex-1 flex flex-col h-full border-r border-gray-200 bg-white">
        
        <!-- Barra de Búsqueda -->
        <div class="p-5 border-b border-gray-100 shrink-0">
            <form method="GET" action="{{ route('ventas.cotizacion.create') }}" class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" autofocus placeholder="Buscar pieza para cotizar (SKU, nombre, aplicación)..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded text-sm text-gray-800 focus:bg-white focus:border-red-500 outline-none transition placeholder-gray-400">
            </form>
        </div>

        <!-- Tabla / Listado de Repuestos Disponibles -->
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-12 gap-4 px-5 py-2 border-b border-gray-100 bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest sticky top-0 z-10">
                <div class="col-span-2">SKU</div>
                <div class="col-span-6">Descripción</div>
                <div class="col-span-2 text-center">Disp.</div>
                <div class="col-span-2 text-right">Precio</div>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($productos ?? [] as $producto)
                <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center hover:bg-blue-50/30 transition group animate-fade-in-up">
                    <div class="col-span-2 font-mono text-xs text-gray-500">{{ $producto->codigo }}</div>
                    <div class="col-span-6">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors">{{ $producto->nombre }}</p>
                        <p class="text-[10px] text-gray-400">{{ $producto->aplicacion ?? 'General' }}</p>
                    </div>
                    <div class="col-span-2 text-center">
                        <span class="text-xs font-bold {{ $producto->stock > 5 ? 'text-green-600' : ($producto->stock > 0 ? 'text-orange-600' : 'text-red-600') }}">
                            {{ $producto->stock }}
                        </span>
                    </div>
                    <div class="col-span-2 text-right flex flex-col items-end gap-1">
                        <span class="text-sm font-bold text-gray-900">${{ number_format($producto->precio, 2) }}</span>
                        <!-- Formulario para agregar producto a la cotización activa -->
                        <form action="{{ route('ventas.cotizacion.agregar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            <button type="submit" class="text-[10px] font-bold text-red-600 hover:underline flex items-center gap-1 cursor-pointer">
                                Añadir <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-gray-500 text-xs">
                    No se encontraron repuestos disponibles para cotizar.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- LADO DERECHO: Documento de Cotización (Borrador) -->
    <div class="w-[420px] shrink-0 bg-gray-50 flex flex-col h-full border-l border-gray-200">
        
        <!-- Encabezado Documento -->
        <div class="px-5 py-4 border-b border-gray-200 bg-white flex justify-between items-center">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Borrador de Cotización</h3>
                <p class="text-[10px] text-gray-400 font-mono">ID: #{{ $numeroCotizacion ?? 'COT-001048' }}</p>
            </div>
            <form action="{{ route('ventas.cotizacion.vaciar') }}" method="POST" onsubmit="return confirm('¿Vaciar la cotización actual?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-[10px] text-gray-400 hover:text-red-600 transition flex items-center gap-1 border border-gray-200 px-2 py-1 rounded bg-white">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Vaciar
                </button>
            </form>
        </div>

        <!-- Formulario de Datos del Cliente y Validez -->
        <form action="{{ route('ventas.cotizacion.guardar') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            
            <div class="p-5 border-b border-gray-200 bg-white space-y-3 shrink-0">
                <div class="flex gap-2">
                    <input type="text" name="cliente_nombre" value="{{ old('cliente_nombre') }}" required placeholder="Nombre del Cliente o Taller..." class="w-full bg-white border border-gray-300 rounded text-xs px-3 py-2 outline-none focus:border-red-500 font-medium text-gray-800">
                </div>
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-green-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </span>
                        <input type="text" name="cliente_whatsapp" value="{{ old('cliente_whatsapp') }}" placeholder="WhatsApp (Ej: 0414-1234567)" class="w-full pl-7 pr-3 py-2 bg-white border border-gray-300 rounded text-xs outline-none focus:border-green-500">
                    </div>
                    <div class="flex-1 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <select name="validez" class="w-full pl-7 pr-3 py-2 bg-white border border-gray-300 rounded text-xs outline-none focus:border-red-500 text-gray-600">
                            <option value="3">Válido: 3 días</option>
                            <option value="1">Válido: Hoy</option>
                            <option value="7">Válido: 1 Semana</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Lista de Repuestos Cotizados (Carrito Temporal / Sesión) -->
            <div class="flex-1 overflow-y-auto p-2 bg-white divide-y divide-gray-50">
                @forelse($itemsCotizacion ?? [] as $item)
                <div class="p-3 hover:bg-gray-50 transition-colors group">
                    <div class="flex justify-between items-start mb-2">
                        <div class="pr-2">
                            <p class="text-xs font-medium text-gray-800 leading-tight">{{ $item['nombre'] }}</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $item['codigo'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center border border-gray-200 rounded text-xs bg-white">
                            <!-- Botón restar cantidad -->
                            <a href="{{ route('ventas.cotizacion.decrementar', $item['id']) }}" class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">-</a>
                            <span class="px-3 py-0.5 border-x border-gray-200 font-medium">{{ $item['cantidad'] }}</span>
                            <!-- Botón sumar cantidad -->
                            <a href="{{ route('ventas.cotizacion.incrementar', $item['id']) }}" class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">+</a>
                        </div>
                        <p class="text-[10px] text-gray-400">{{ $item['cantidad'] }} x ${{ number_format($item['precio'], 2) }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-gray-400 text-xs">
                    No hay repuestos añadidos a la cotización.
                </div>
                @endforelse
            </div>

            <!-- Totales y Acciones Finales -->
            <div class="p-5 border-t border-gray-200 bg-white shrink-0">
                @php
                    $subtotal = $subtotal ?? 0;
                    $iva = $subtotal * 0.16; // 16% IVA Venezuela
                    $total = $subtotal + $iva;
                @endphp

                <div class="space-y-1 mb-4 text-sm">
                    <div class="flex justify-between text-gray-500 text-xs">
                        <span>Subtotal Estimado</span>
                        <span class="text-gray-800 font-medium">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500 text-xs">
                        <span>IVA (16%)</span>
                        <span class="text-gray-800 font-medium">${{ number_format($iva, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-end pt-3 border-t border-gray-100 mt-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Cotización</span>
                        <span class="text-3xl font-black text-gray-900 leading-none">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
                
                <div class="flex flex-col gap-2 mt-4">
                    <!-- Guardar y Generar PDF -->
                    <button type="submit" name="accion" value="pdf" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded text-xs transition-colors flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Guardar y Generar PDF
                    </button>
                    <!-- Enviar por WhatsApp -->
                    <button type="submit" name="accion" value="whatsapp" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded text-xs transition-colors flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Enviar cotización por WhatsApp
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection