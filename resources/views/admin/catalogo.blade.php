@extends('layout')

@section('titulo', 'Catálogo Visual')

@section('contenido')
<div class="max-w-7xl mx-auto w-full">
    
    <!-- Encabezado de la página -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Catálogo Visual</h2>
            <p class="text-gray-500 mt-1 text-sm">Verificación fotográfica y especificaciones técnicas de repuestos.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-red-600 text-white px-4 py-2.5 rounded-lg font-bold text-[11px] uppercase tracking-widest shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:bg-red-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Subir Imágenes Masivas
            </button>
        </div>
    </div>

    <!-- Barra de Filtros del Catálogo -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.catalogo', ['filtro' => 'todos']) }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-widest shadow-sm">Todos</a>
            <a href="{{ route('admin.catalogo', ['filtro' => 'inyeccion']) }}" class="bg-white border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-500 px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-widest transition">Inyección</a>
            <a href="{{ route('admin.catalogo', ['filtro' => 'motores']) }}" class="bg-white border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-500 px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-widest transition">Motores</a>
            <a href="{{ route('admin.catalogo', ['filtro' => 'filtros']) }}" class="bg-white border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-500 px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-widest transition">Filtros</a>
        </div>
        
        <!-- Buscador -->
        <form action="{{ route('admin.catalogo') }}" method="GET" class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por código SKU o modelo..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-red-500 outline-none transition">
        </form>
    </div>

    <!-- Grilla del Catálogo (Fotos) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        @forelse($repuestos ?? [] as $repuesto)
            <!-- Tarjeta Dinámica de Base de Datos -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden group hover:border-red-300 hover:shadow-lg transition-all flex flex-col">
                <div class="relative h-48 w-full {{ $repuesto->imagen ? 'bg-gray-100' : 'bg-gray-50 border-b border-gray-100 flex flex-col items-center justify-center text-gray-300' }} overflow-hidden">
                    
                    @if($repuesto->imagen)
                        <img src="{{ asset('storage/' . $repuesto->imagen) }}" alt="{{ $repuesto->nombre }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Sin Imagen</p>
                    @endif

                    <!-- Etiqueta de Stock Dinámica -->
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest border shadow-sm 
                        {{ $repuesto->stock == 0 ? 'text-red-600 border-red-200' : ($repuesto->stock <= 5 ? 'text-orange-600 border-orange-200' : 'text-gray-800 border-gray-200') }}">
                        @if($repuesto->stock == 0) Agotado @elseif($repuesto->stock <= 5) Crítico: {{ $repuesto->stock }} @else Stock: {{ $repuesto->stock }} @endif
                    </div>

                    <div class="absolute inset-0 {{ $repuesto->imagen ? 'bg-black/40' : 'bg-gray-900/5' }} flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="{{ $repuesto->imagen ? 'bg-white text-gray-900 hover:bg-red-600 hover:text-white' : 'bg-red-600 text-white hover:bg-red-700 shadow-lg' }} px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $repuesto->imagen ? 'Cambiar' : 'Subir Foto' }}
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-[10px] font-mono text-gray-400 mb-1">SKU: {{ $repuesto->sku }}</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">{{ $repuesto->nombre }}</h3>
                    <p class="text-xs text-gray-500 mb-4">Marca: {{ $repuesto->marca }} / Aplica: {{ $repuesto->aplica_a }}</p>
                    
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-900">${{ number_format($repuesto->precio, 2) }}</span>
                        <a href="{{ route('admin.repuestos.edit', $repuesto->id ?? 1) }}" class="text-gray-400 hover:text-blue-600 transition" title="Editar Detalles">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

        @empty
            <!-- Tarjeta 1: Con Foto (Fallback) -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden group hover:border-red-300 hover:shadow-lg transition-all flex flex-col">
                <div class="relative h-48 w-full bg-gray-100 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1635769165993-9c87d4653549?q=80&w=400&auto=format&fit=crop" alt="Filtro" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold text-gray-800 uppercase tracking-widest border border-gray-200 shadow-sm">
                        Stock: 45
                    </div>
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="bg-white text-gray-900 px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-red-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Cambiar
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-[10px] font-mono text-gray-400 mb-1">SKU: FIL-045</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Filtro de Gasoil Secundario</h3>
                    <p class="text-xs text-gray-500 mb-4">Marca: Donaldson / Aplica: Encava</p>
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-900">$25.50</span>
                        <button class="text-gray-400 hover:text-blue-600 transition" title="Editar Detalles">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Con Foto (Fallback) -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden group hover:border-red-300 hover:shadow-lg transition-all flex flex-col">
                <div class="relative h-48 w-full bg-gray-100 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=400&auto=format&fit=crop" alt="Repuesto" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold text-orange-600 uppercase tracking-widest border border-orange-200 shadow-sm">
                        Crítico: 4
                    </div>
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="bg-white text-gray-900 px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-red-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Cambiar
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-[10px] font-mono text-gray-400 mb-1">SKU: INY-112</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Inyector Principal Bosch</h3>
                    <p class="text-xs text-gray-500 mb-4">Marca: Bosch / Aplica: Cargo 815</p>
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-900">$140.00</span>
                        <button class="text-gray-400 hover:text-blue-600 transition" title="Editar Detalles">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3: SIN FOTO (Fallback) -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-200 overflow-hidden group hover:border-red-300 hover:shadow-lg transition-all flex flex-col">
                <div class="relative h-48 w-full bg-gray-50 border-b border-gray-100 flex flex-col items-center justify-center text-gray-300">
                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Sin Imagen</p>
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold text-gray-800 uppercase tracking-widest border border-gray-200 shadow-sm">
                        Stock: 12
                    </div>
                    <div class="absolute inset-0 bg-gray-900/5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 shadow-lg hover:bg-red-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Subir Foto
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-[10px] font-mono text-gray-400 mb-1">SKU: EST-099</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Estopera Trasera Cigueñal</h3>
                    <p class="text-xs text-gray-500 mb-4">Marca: Sabo / Aplica: NPR 4HG1</p>
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-900">$18.00</span>
                        <button class="text-gray-400 hover:text-blue-600 transition" title="Editar Detalles">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4: Con Foto (Fallback) -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden group hover:border-red-300 hover:shadow-lg transition-all flex flex-col">
                <div class="relative h-48 w-full bg-gray-100 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1616788806509-f62800537446?q=80&w=400&auto=format&fit=crop" alt="Correa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold text-red-600 uppercase tracking-widest border border-red-200 shadow-sm">
                        Agotado
                    </div>
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="bg-white text-gray-900 px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-red-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Cambiar
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-[10px] font-mono text-gray-400 mb-1">SKU: COR-88X</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">Correa de Alternador</h3>
                    <p class="text-xs text-gray-500 mb-4">Marca: Gates / Aplica: Isuzu NPR</p>
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-900">$32.00</span>
                        <button class="text-gray-400 hover:text-blue-600 transition" title="Editar Detalles">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforelse

    </div>
</div>
@endsection