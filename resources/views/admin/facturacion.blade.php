@extends('layout')

@section('titulo', 'Punto de Venta - Mostrador')

@section('contenido')
<!-- Envolvemos el módulo en un contenedor que ocupe todo el alto disponible -->
<div class="flex-1 flex flex-col lg:flex-row overflow-hidden h-[calc(100vh-5.5rem)] -m-4 md:-m-8 bg-gray-50 border-t border-gray-200">
    
    <!-- LADO IZQUIERDO: Buscador y Lista de Productos (65%) -->
    <div class="flex-1 flex flex-col h-full border-r border-gray-200 bg-white">
        
        <!-- Buscador y Filtros -->
        <div class="p-5 border-b border-gray-100 shrink-0 space-y-3">
            <form action="/admin/facturacion" method="GET" class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="buscar" value="{{ request('buscar') }}" autofocus placeholder="Buscar repuesto por SKU, nombre o marca..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded text-sm text-gray-800 focus:bg-white focus:border-red-500 outline-none transition placeholder-gray-400">
            </form>
            
            <!-- Filtros Rápidos -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                <a href="/admin/facturacion?filtro=todos" class="px-3 py-1 rounded-full font-medium transition {{ request('filtro', 'todos') == 'todos' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Todos</a>
                <a href="/admin/facturacion?filtro=inyeccion" class="px-3 py-1 rounded-full font-medium transition {{ request('filtro') == 'inyeccion' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Inyección</a>
                <a href="/admin/facturacion?filtro=frenos" class="px-3 py-1 rounded-full font-medium transition {{ request('filtro') == 'frenos' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Frenos</a>
                <a href="/admin/facturacion?filtro=filtros" class="px-3 py-1 rounded-full font-medium transition {{ request('filtro') == 'filtros' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Filtros</a>
            </div>
        </div>

        <!-- Lista de Productos (Alta Densidad) -->
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-12 gap-4 px-5 py-2 border-b border-gray-100 bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest sticky top-0 bg-white z-10">
                <div class="col-span-3 md:col-span-2">SKU</div>
                <div class="col-span-5 md:col-span-6">Descripción</div>
                <div class="col-span-2 text-center">Stock</div>
                <div class="col-span-2 text-right">Precio</div>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($productos ?? [] as $producto)
                    
                    @if($producto->stock > 0)
                        <!-- Producto Disponible -->
                        <form action="/admin/facturacion/agregar" method="POST" class="grid grid-cols-12 gap-4 px-5 py-3 items-center hover:bg-blue-50/30 transition group cursor-pointer" onclick="this.submit();">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            <div class="col-span-3 md:col-span-2 font-mono text-xs text-gray-500">{{ $producto->sku }}</div>
                            <div class="col-span-5 md:col-span-6">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors">{{ $producto->nombre }}</p>
                                <p class="text-[10px] text-gray-400">{{ $producto->marca }} / {{ $producto->aplica_a }}</p>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="text-xs font-bold {{ $producto->stock <= 5 ? 'text-orange-600 bg-orange-50 border-orange-100' : 'text-green-600 bg-green-50 border-green-100' }} px-2 py-0.5 rounded border">{{ $producto->stock }}</span>
                            </div>
                            <div class="col-span-2 text-right flex flex-col items-end gap-1">
                                <span class="text-sm font-bold text-gray-900">${{ number_format($producto->precio, 2) }}</span>
                                <button type="submit" class="text-[10px] font-bold text-red-600 opacity-0 group-hover:opacity-100 transition flex items-center gap-1">
                                    Añadir <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Producto Agotado -->
                        <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center opacity-60 bg-gray-50 cursor-not-allowed">
                            <div class="col-span-3 md:col-span-2 font-mono text-xs text-gray-400">{{ $producto->sku }}</div>
                            <div class="col-span-5 md:col-span-6">
                                <p class="text-sm font-medium text-gray-500">{{ $producto->nombre }}</p>
                                <p class="text-[10px] text-gray-400">{{ $producto->marca }}</p>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="text-[10px] font-bold text-red-500 border border-red-200 px-1.5 py-0.5 rounded bg-white">Agotado</span>
                            </div>
                            <div class="col-span-2 text-right">
                                <span class="text-sm font-bold text-gray-400">${{ number_format($producto->precio, 2) }}</span>
                            </div>
                        </div>
                    @endif

                @empty
                    <!-- DATOS ESTÁTICOS DE PRUEBA (Fallback) -->
                    <!-- Producto 1 -->
                    <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center hover:bg-blue-50/30 transition group cursor-pointer">
                        <div class="col-span-3 md:col-span-2 font-mono text-xs text-gray-500">FIL-045</div>
                        <div class="col-span-5 md:col-span-6">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors">Filtro de Gasoil Secundario</p>
                            <p class="text-[10px] text-gray-400">Encava / NPR</p>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100">45</span>
                        </div>
                        <div class="col-span-2 text-right flex flex-col items-end gap-1">
                            <span class="text-sm font-bold text-gray-900">$25.50</span>
                            <button class="text-[10px] font-bold text-red-600 opacity-0 group-hover:opacity-100 transition flex items-center gap-1">
                                Añadir <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Producto 2 -->
                    <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center hover:bg-blue-50/30 transition group cursor-pointer">
                        <div class="col-span-3 md:col-span-2 font-mono text-xs text-gray-500">INY-112</div>
                        <div class="col-span-5 md:col-span-6">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors">Inyector Principal Bosch</p>
                            <p class="text-[10px] text-gray-400">Cargo 815</p>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded border border-orange-100">12</span>
                        </div>
                        <div class="col-span-2 text-right flex flex-col items-end gap-1">
                            <span class="text-sm font-bold text-gray-900">$140.00</span>
                            <button class="text-[10px] font-bold text-red-600 opacity-0 group-hover:opacity-100 transition flex items-center gap-1">
                                Añadir <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Producto Agotado -->
                    <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center opacity-60 bg-gray-50 cursor-not-allowed">
                        <div class="col-span-3 md:col-span-2 font-mono text-xs text-gray-400">ACE-001</div>
                        <div class="col-span-5 md:col-span-6">
                            <p class="text-sm font-medium text-gray-500">Aceite Diesel 15W40 Paila</p>
                            <p class="text-[10px] text-gray-400">PDV</p>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-[10px] font-bold text-red-500 border border-red-200 px-1.5 py-0.5 rounded bg-white">Agotado</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-sm font-bold text-gray-400">$65.00</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- LADO DERECHO: Factura / Caja Limpia (35%) -->
    <div class="w-full lg:w-[400px] shrink-0 bg-gray-50 flex flex-col h-full z-10 border-t lg:border-t-0 lg:border-l border-gray-200 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.05)]">
        
        <!-- Encabezado Ticket -->
        <div class="px-5 py-4 border-b border-gray-200 bg-white flex justify-between items-center">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Ticket en curso</h3>
                <p class="text-[10px] text-gray-400 font-mono">ID: #{{ $ticketId ?? '001045' }}</p>
            </div>
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="text-[10px] text-gray-400 hover:text-red-600 transition flex items-center gap-1 border border-gray-200 px-2 py-1 rounded bg-white shadow-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Vaciar
                </button>
            </form>
        </div>

        <!-- Datos del Cliente -->
        <div class="p-5 border-b border-gray-200 bg-white">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Cliente</label>
            <div class="flex gap-2 mb-2">
                <select name="tipo_doc" class="w-16 bg-white border border-gray-300 rounded text-xs px-1 py-1.5 outline-none focus:border-red-500 transition">
                    <option value="V">V-</option>
                    <option value="J">J-</option>
                    <option value="E">E-</option>
                    <option value="G">G-</option>
                </select>
                <input type="text" name="documento" placeholder="Documento" class="flex-1 bg-white border border-gray-300 rounded text-xs px-2 py-1.5 outline-none focus:border-red-500 font-mono transition">
                <button type="button" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-600 px-3 rounded transition flex items-center justify-center">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
            <input type="text" name="nombre" placeholder="Nombre o Razón Social..." class="w-full bg-white border border-gray-300 rounded text-xs px-3 py-2 outline-none focus:border-red-500 transition">
        </div>

        <!-- Lista de Repuestos en el Ticket -->
        <div class="flex-1 overflow-y-auto p-2 bg-white">
            @forelse($carrito ?? [] as $item)
                <!-- Item dinámico del carrito -->
                <div class="p-3 border-b border-gray-100 hover:bg-gray-50 transition-colors group">
                    <div class="flex justify-between items-start mb-2">
                        <div class="pr-2">
                            <p class="text-xs font-medium text-gray-800 leading-tight">{{ $item->producto->nombre }}</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $item->producto->sku }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center border border-gray-200 rounded text-xs">
                            <form action="/admin/facturacion/restar/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">-</button>
                            </form>
                            <span class="px-3 py-0.5 border-x border-gray-200 font-medium">{{ $item->cantidad }}</span>
                            <form action="/admin/facturacion/sumar/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">+</button>
                            </form>
                        </div>
                        <p class="text-[10px] text-gray-400">{{ $item->cantidad }} x ${{ number_format($item->precio, 2) }}</p>
                    </div>
                </div>
            @empty
                <!-- Fallback Estático -->
                <div class="p-3 border-b border-gray-100 hover:bg-gray-50 transition-colors group">
                    <div class="flex justify-between items-start mb-2">
                        <div class="pr-2">
                            <p class="text-xs font-medium text-gray-800 leading-tight">Filtro de Gasoil Secundario</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">FIL-045</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">$51.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center border border-gray-200 rounded text-xs">
                            <button class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">-</button>
                            <span class="px-3 py-0.5 border-x border-gray-200 font-medium">2</span>
                            <button class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">+</button>
                        </div>
                        <p class="text-[10px] text-gray-400">2 x $25.50</p>
                    </div>
                </div>

                <div class="p-3 border-b border-gray-100 hover:bg-gray-50 transition-colors group">
                    <div class="flex justify-between items-start mb-2">
                        <div class="pr-2">
                            <p class="text-xs font-medium text-gray-800 leading-tight">Correa de Tiempo Isuzu</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">COR-88</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">$32.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center border border-gray-200 rounded text-xs">
                            <button class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">-</button>
                            <span class="px-3 py-0.5 border-x border-gray-200 font-medium">1</span>
                            <button class="px-2 py-0.5 text-gray-500 hover:bg-gray-100 transition">+</button>
                        </div>
                        <p class="text-[10px] text-gray-400">1 x $32.00</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Totales y Pago -->
        <div class="p-5 border-t border-gray-200 bg-white">
            <div class="space-y-1 mb-4 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span class="text-gray-800 font-medium">${{ number_format($subtotal ?? 83.00, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>IVA (16%)</span>
                    <span class="text-gray-800 font-medium">${{ number_format($iva ?? 13.28, 2) }}</span>
                </div>
                <div class="flex justify-between items-end pt-3 border-t border-gray-100 mt-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total</span>
                    <span class="text-3xl font-black text-gray-900 leading-none">${{ number_format($total ?? 96.28, 2) }}</span>
                </div>
            </div>
            
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded text-sm transition-colors shadow-md flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Cobrar Exacto
                </button>
            </form>
            
            <button class="w-full mt-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded text-xs transition-colors">
                Generar Presupuesto
            </button>
        </div>

    </div>
</div>
@endsection