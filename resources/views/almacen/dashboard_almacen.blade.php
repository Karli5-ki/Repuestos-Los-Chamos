@extends('layout')

@section('titulo', 'Panel de Almacén - Repuestos Los Chamos')

{{-- Si tienes un @stack('styles') en tu layout, puedes usar @push('styles'), si no, déjalo aquí adentro --}}
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
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
</style>

<!-- CONTENIDO DEL DASHBOARD DE ALMACÉN -->
<div class="p-6 max-w-7xl mx-auto w-full">
    
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-6 gap-4 animate-fade-in-up">
        <div>
            <!-- Saludo dinámico obteniendo solo el primer nombre -->
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">¡Hola, {{ explode(' ', Auth::user()->name ?? 'José')[0] }}! 👋</h2>
            <!-- Fecha dinámica en español usando Carbon -->
            <p class="text-gray-500 mt-1 text-xs">Resumen operativo para hoy, {{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e Y') }}.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('almacen.reporte') }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded text-xs font-bold hover:bg-gray-50 transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Descargar Reporte
            </a>
            <a href="{{ route('almacen.recepcion.create') }}" class="bg-red-600 text-white px-4 py-2 rounded text-xs font-bold hover:bg-red-700 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Recepcionar Pedido
            </a>
        </div>
    </div>

    <!-- 1. KPIs Logísticos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-100 flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Stock Total</p>
                <h3 class="text-2xl font-black text-gray-800">{{ number_format($stockTotal ?? 0) }}</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-200 flex items-center gap-4 border-l-4 border-l-orange-500">
            <div class="p-3 bg-orange-50 text-orange-500 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Nivel Crítico</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $nivelCritico ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-300 flex items-center gap-4 border-l-4 border-l-red-600">
            <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Agotados</p>
                <h3 class="text-2xl font-black text-red-600">{{ $agotados ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-400 flex items-center gap-4">
            <div class="p-3 bg-gray-100 text-gray-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">En Tránsito</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $enTransito ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- 2. Gráficos y Top para Reposición -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 lg:col-span-2 animate-fade-in-up delay-200">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Movimiento Físico (Unidades)</h3>
                    <p class="text-sm font-medium text-gray-600 mt-1">Entradas vs. Salidas (Últimos 7 días)</p>
                </div>
            </div>
            <!-- Div para ApexCharts -->
            <div id="movementChart" class="w-full h-64 mt-2"></div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 animate-fade-in-up delay-300">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Requieren Reabastecimiento</h3>
            <div class="space-y-4">
                
                @forelse($productosCriticos ?? [] as $producto)
                <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded transition border border-transparent hover:border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-gray-800">{{ $producto->nombre }}</p>
                        <p class="text-[10px] text-gray-500 font-mono">{{ $producto->codigo }}</p>
                    </div>
                    @if($producto->stock == 0)
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">Stock: 0</span>
                    @else
                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded">Stock: {{ $producto->stock }}</span>
                    @endif
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-xs text-gray-500">Todo el inventario está en niveles óptimos.</p>
                </div>
                @endforelse

                <a href="{{ route('almacen.orden_compra.create') }}" class="block w-full text-center mt-2 py-2 text-xs font-bold text-gray-600 border border-gray-300 rounded hover:bg-gray-50 transition">
                    Generar Orden de Compra
                </a>
            </div>
        </div>
    </div>

    <!-- 3. Bitácora de Movimientos Recientes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up delay-400">
        <div class="px-5 py-3 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Bitácora de Movimientos (Hoy)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] uppercase tracking-widest text-gray-400 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3">Hora</th>
                        <th class="px-5 py-3">Tipo</th>
                        <th class="px-5 py-3">Repuesto</th>
                        <th class="px-5 py-3 text-center">Cantidad</th>
                        <th class="px-5 py-3">Responsable</th>
                        <th class="px-5 py-3 text-right">Documento</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($movimientos ?? [] as $movimiento)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-2.5 text-xs text-gray-500">{{ $movimiento->created_at->format('h:i A') }}</td>
                        <td class="px-5 py-2.5">
                            @if($movimiento->tipo === 'entrada')
                                <span class="text-[10px] font-bold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded">Entrada</span>
                            @elseif($movimiento->tipo === 'salida')
                                <span class="text-[10px] font-bold text-red-600 bg-red-50 border border-red-100 px-2 py-0.5 rounded">Salida</span>
                            @else
                                <span class="text-[10px] font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded">Ajuste</span>
                            @endif
                        </td>
                        <td class="px-5 py-2.5 text-xs font-medium text-gray-800">{{ $movimiento->repuesto->nombre }}</td>
                        <td class="px-5 py-2.5 text-center text-xs font-bold {{ $movimiento->tipo === 'entrada' ? 'text-green-600' : ($movimiento->tipo === 'salida' ? '' : '') }}">
                            {{ $movimiento->tipo === 'salida' ? '-' : '+' }}{{ $movimiento->cantidad }}
                        </td>
                        <td class="px-5 py-2.5 text-xs">{{ $movimiento->usuario->name }}</td>
                        <td class="px-5 py-2.5 text-right font-mono text-xs text-blue-600 hover:underline cursor-pointer">
                            {{ $movimiento->documento ?? 'Manual' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-4 text-center text-xs text-gray-500">No hay movimientos registrados hoy.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Scripts para las gráficas --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Aquí deberías inyectar los datos desde el controlador usando JSON
        // Ejemplo: data: {!! json_encode($entradasData) !!}
        var options = {
            series: [{
                name: 'Entradas (Reabastecimiento)',
                data: [120, 0, 45, 0, 200, 10, 50] 
            }, {
                name: 'Salidas (Ventas/Despachos)',
                data: [35, 42, 58, 40, 65, 20, 15]
            }],
            chart: {
                type: 'area',
                height: 250,
                toolbar: { show: false },
                fontFamily: 'inherit',
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            colors: ['#10b981', '#ef4444'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05, stops: [0, 100] }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Hoy'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 600 } }
            },
            yaxis: {
                labels: { style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 600 } }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontSize: '11px',
                markers: { radius: 2 }
            },
            tooltip: { theme: 'light' }
        };

        var chart = new ApexCharts(document.querySelector("#movementChart"), options);
        chart.render();
    });
</script>
@endsection