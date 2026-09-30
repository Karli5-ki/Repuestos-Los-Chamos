@extends('layout')

@section('titulo', 'Panel Gerencial')

@section('contenido')
<!-- Animaciones de Carga -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { 
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
        opacity: 0; 
    }
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
</style>

<div class="max-w-7xl mx-auto w-full">
    
    <!-- Encabezado de bienvenida dinámico -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4 animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                ¡Hola, {{ auth()->user()->name ?? 'Carlos' }}! 👋
            </h2>
            <p class="text-gray-500 mt-1 text-sm">
                Aquí tienes el resumen de hoy, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}.
            </p>
        </div>
        <button class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold text-[11px] uppercase tracking-widest shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Reporte del Mes
        </button>
    </div>

    <!-- Metricas Principales (KPIs) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Ingresos -->
        <div class="bg-white p-6 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 border-l-4 border-l-green-500 animate-fade-in-up delay-100">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Ingresos de Hoy</p>
            <h3 class="text-3xl font-black text-gray-800">${{ number_format($ingresosHoy ?? 0, 2) }}</h3>
            <p class="text-green-600 text-[11px] font-bold mt-2 flex items-center gap-1">Sin movimientos previos</p>
        </div>
        <!-- Ventas -->
        <div class="bg-white p-6 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 border-l-4 border-l-gray-800 animate-fade-in-up delay-200">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Facturas Emitidas</p>
            <h3 class="text-3xl font-black text-gray-800">{{ $facturasHoy ?? 0 }}</h3>
            <p class="text-gray-500 text-[11px] font-medium mt-2">Promedio: ${{ number_format($promedioTicket ?? 0, 2) }}/ticket</p>
        </div>
        <!-- Alertas -->
        <div class="bg-white p-6 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 border-l-4 border-l-red-600 animate-fade-in-up delay-300">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Alertas Almacén</p>
            <h3 class="text-3xl font-black text-red-600">{{ $alertasAlmacen ?? 0 }}</h3>
            <p class="text-red-500 text-[11px] font-bold mt-2">Repuestos críticos</p>
        </div>
        <!-- Cuentas -->
        <div class="bg-white p-6 rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 border-l-4 border-l-orange-500 animate-fade-in-up delay-400">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Cuentas por Pagar</p>
            <h3 class="text-3xl font-black text-gray-800">${{ number_format($cuentasPorPagar ?? 0, 2) }}</h3>
            <p class="text-orange-600 text-[11px] font-bold mt-2">A proveedores</p>
        </div>
    </div>

    <!-- Gráficos Reales y Top Ventas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        <!-- GRÁFICO PROFESIONAL CON APEXCHARTS -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 p-6 lg:col-span-2 flex flex-col animate-fade-in-up delay-200">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Flujo de Ingresos</h3>
                    <h4 class="text-xl font-black text-gray-900 mt-1">${{ number_format($totalFlujoSemanal ?? 0, 2) }}</h4>
                </div>
                
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button class="px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-gray-900 transition">Hoy</button>
                    <button class="px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest bg-white text-gray-900 shadow-sm transition">7 Días</button>
                    <button class="px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-gray-900 transition">Mes</button>
                </div>
            </div>
            
            <div id="revenueChart" class="w-full h-64 mt-4"></div>
        </div>

        <!-- Lista de Top Vendidos -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 p-6 animate-fade-in-up delay-300">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Piezas Más Rotadas (Mes)</h3>
            <div class="space-y-5">
                @forelse($piezasRotadas ?? [] as $pieza)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold text-gray-800">{{ $pieza->nombre }}</span>
                            <span class="text-[10px] font-bold text-gray-500">{{ $pieza->unidades }} Unds</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="bg-red-600 h-1.5 rounded-full" style="width: {{ $pieza->porcentaje }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <p class="text-xs text-gray-400 font-medium">No hay registros de piezas rotadas este mes.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Tabla Actividad -->
    <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden animate-fade-in-up delay-400">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Transacciones Recientes</h3>
            <span class="flex items-center gap-2 text-[10px] font-bold text-green-600 uppercase tracking-widest"><span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> En vivo</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-white text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 font-bold">Nº Factura</th>
                        <th class="px-6 py-3 font-bold">Hora</th>
                        <th class="px-6 py-3 font-bold">Vendedor</th>
                        <th class="px-6 py-3 font-bold text-right">Total Transacción</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y divide-gray-50">
                    @forelse($transaccionesRecientes ?? [] as $transaccion)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-mono text-xs font-bold text-gray-900">#{{ $transaccion->numero_factura }}</td>
                            <td class="px-6 py-3 text-xs">{{ $transaccion->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-3 text-xs font-medium">{{ $transaccion->vendedor->name }}</td>
                            <td class="px-6 py-3 text-right font-bold text-green-600">+${{ number_format($transaccion->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-xs text-gray-400 font-medium">
                                No se registran transacciones recientes en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Carga de la librería ApexCharts y su script de inicialización -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Ingresos Diarios ($)',
                data: {!! json_encode($datosGrafico ?? [0, 0, 0, 0, 0, 0, 0]) !!}
            }],
            chart: {
                type: 'area',
                height: 280,
                toolbar: { show: false },
                fontFamily: 'inherit',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: { enabled: true, delay: 150 },
                    dynamicAnimation: { enabled: true, speed: 350 }
                }
            },
            colors: ['#dc2626'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: {!! json_encode($diasGrafico ?? ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Hoy']) !!},
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#9ca3af', fontSize: '12px', fontWeight: 600 } }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 600 },
                    formatter: function (value) { return "$" + value; }
                }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
                xaxis: { lines: { show: false } }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return "$" + val.toFixed(2) } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    });
</script>
@endsection