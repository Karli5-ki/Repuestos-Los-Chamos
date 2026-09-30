@extends('layout')

@section('titulo', 'Panel Comercial - Repuestos Los Chamos')

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

<!-- CONTENIDO DEL DASHBOARD COMERCIAL -->
<div class="p-6 max-w-7xl mx-auto w-full">
    
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-6 gap-4 animate-fade-in-up">
        <div>
            <!-- Saludo dinámico -->
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">¡Hola, {{ explode(' ', Auth::user()->name ?? 'María')[0] }}! 👋</h2>
            <p class="text-gray-500 mt-1 text-xs">Resumen de tus ventas de hoy, {{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e Y') }}.</p>
        </div>
        <div class="flex gap-2">
            <!-- Asumiendo que crearás una ruta para el corte de caja -->
            <a href="{{ route('ventas.corte_caja') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded text-xs font-bold hover:bg-gray-50 transition shadow-sm text-center">
                Corte de Caja (Turno)
            </a>
            <!-- Ruta corregida hacia facturación -->
            <a href="{{ route('ventas.facturacion') }}" class="bg-red-600 text-white px-4 py-2 rounded text-xs font-bold hover:bg-red-700 transition shadow-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Factura
            </a>
        </div>
    </div>

    <!-- 1. KPIs Comerciales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Ventas Personales -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-100 border-l-4 border-l-green-500">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Mis Ventas (Hoy)</p>
            <h3 class="text-2xl font-black text-gray-800">${{ number_format($misVentasHoy ?? 0, 2) }}</h3>
            <!-- Cálculo del porcentaje de aumento (Opcional, manejado desde controlador) -->
            <p class="{{ ($porcentajeCrecimiento ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} text-[10px] font-bold mt-1">
                {{ ($porcentajeCrecimiento ?? 0) >= 0 ? '↑' : '↓' }} {{ abs($porcentajeCrecimiento ?? 0) }}% vs ayer
            </p>
        </div>
        <!-- Operaciones -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-200 border-l-4 border-l-blue-500">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Tickets Emitidos</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $ticketsEmitidos ?? 0 }}</h3>
            <p class="text-gray-500 text-[10px] font-medium mt-1">Promedio: ${{ number_format($promedioTicket ?? 0, 2) }} / ticket</p>
        </div>
        <!-- Cotizaciones Pendientes -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-300 border-l-4 border-l-orange-500">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Cotizaciones Abiertas</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $cotizacionesAbiertas ?? 0 }}</h3>
            <p class="text-orange-500 text-[10px] font-bold mt-1">Requieren seguimiento</p>
        </div>
        <!-- Meta Diaria (Progreso) -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 animate-fade-in-up delay-400 flex flex-col justify-center">
            <div class="flex justify-between items-end mb-1">
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Meta Diaria (${{ number_format($metaDiaria ?? 600, 0) }})</p>
                <span class="text-xs font-black text-gray-800">{{ $porcentajeMeta ?? 0 }}%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2 mt-1">
                <div class="bg-red-600 h-2 rounded-full" style="width: {{ $porcentajeMeta ?? 0 }}%"></div>
            </div>
            <p class="text-gray-500 text-[10px] font-medium mt-1.5 text-right">Faltan ${{ number_format(max(0, ($metaDiaria ?? 600) - ($misVentasHoy ?? 0)), 2) }}</p>
        </div>
    </div>

    <!-- 2. Gráficos y Seguimiento -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        <!-- GRÁFICO: Mi Rendimiento (Barras) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 lg:col-span-2 animate-fade-in-up delay-200">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Mi Rendimiento en Ventas</h3>
                    <p class="text-sm font-medium text-gray-600 mt-1">Semana Actual</p>
                </div>
            </div>
            <!-- Div para ApexCharts -->
            <div id="salesChart" class="w-full h-64 mt-2"></div>
        </div>

        <!-- Lista: Presupuestos por Cerrar -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 animate-fade-in-up delay-300 flex flex-col">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Seguimiento de Cotizaciones</h3>
            <div class="space-y-3 flex-1">
                
                @forelse($cotizacionesRecientes ?? [] as $cotizacion)
                <div class="p-3 border border-gray-100 hover:border-red-200 hover:shadow-sm rounded-lg transition group">
                    <div class="flex justify-between items-start mb-1">
                        <p class="text-xs font-bold text-gray-800">{{ $cotizacion->cliente->nombre }}</p>
                        <span class="text-xs font-black text-gray-900">${{ number_format($cotizacion->total, 2) }}</span>
                    </div>
                    <p class="text-[10px] text-gray-500 font-mono mb-2">Presupuesto #{{ $cotizacion->codigo }} • {{ $cotizacion->created_at->diffForHumans() }}</p>
                    <div class="flex gap-2">
                        <!-- Botón para mandar a facturar -->
                        <a href="{{ route('ventas.facturacion.create', ['cotizacion_id' => $cotizacion->id]) }}" class="flex-1 bg-red-50 text-red-600 text-[10px] font-bold py-1 rounded transition hover:bg-red-600 hover:text-white text-center flex items-center justify-center">
                            Facturar
                        </a>
                        <!-- Botón para contacto de WhatsApp -->
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cotizacion->cliente->telefono) }}" target="_blank" class="bg-gray-100 text-gray-600 px-2 py-1 rounded transition hover:bg-gray-200 flex items-center justify-center" title="Contactar por WhatsApp">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-500 text-xs">
                    No tienes cotizaciones abiertas.
                </div>
                @endforelse

            </div>
        </div>
    </div>

    <!-- 3. Mis Transacciones Recientes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up delay-400">
        <div class="px-5 py-3 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Mis Facturas de Hoy</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] uppercase tracking-widest text-gray-400 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3">Documento</th>
                        <th class="px-5 py-3">Hora</th>
                        <th class="px-5 py-3">Cliente</th>
                        <th class="px-5 py-3 text-center">Artículos</th>
                        <th class="px-5 py-3">Método de Pago</th>
                        <th class="px-5 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($facturasHoy ?? [] as $factura)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-2.5 font-mono text-xs font-bold text-gray-900">
                            <a href="{{ route('ventas.facturacion.show', $factura->id) }}" class="hover:text-blue-600 transition">{{ $factura->codigo }}</a>
                        </td>
                        <td class="px-5 py-2.5 text-xs text-gray-500">{{ $factura->created_at->format('h:i A') }}</td>
                        <td class="px-5 py-2.5 text-xs">{{ $factura->cliente->nombre }} ({{ $factura->cliente->documento }})</td>
                        <td class="px-5 py-2.5 text-center text-xs text-gray-500">{{ $factura->detalles->sum('cantidad') }}</td>
                        <td class="px-5 py-2.5 text-xs text-gray-500">{{ $factura->metodo_pago }}</td>
                        <td class="px-5 py-2.5 text-right font-bold text-green-600">${{ number_format($factura->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-4 text-center text-xs text-gray-500">Aún no has procesado facturas el día de hoy.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
    
</div>

<!-- Scripts para la gráfica -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtenemos los datos de la gráfica enviados por el controlador. 
        // Si no existen (ej: entorno de desarrollo inicial), usamos los estáticos como fallback.
        const ventasData = @json($ventasSemana);
        var options = {
            series: [{
                name: 'Ventas Cerradas ($)',
                data: ventasData
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: { show: false },
                fontFamily: 'inherit',
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            colors: ['#dc2626'], // Rojo corporativo
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '40%',
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 600 } }
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
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } }
            },
            tooltip: { theme: 'light' }
        };

        var chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();
    });
</script>
@endsection