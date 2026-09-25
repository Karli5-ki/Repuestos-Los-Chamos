@extends('layout') <!-- Asegúrate de que este sea el nombre de tu layout principal -->

@section('contenido')
<div class="p-6 max-w-7xl mx-auto w-full">
    
    <!-- Encabezado y KPIs -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Inventario de Repuestos</h1>
            <p class="text-sm text-gray-500">Gestiona las piezas y el stock de Repuestos Los Chamos</p>
        </div>

        <!-- Contenedor de KPIs -->
        <div class="flex gap-4">
            <!-- KPI: Stock Crítico -->
            <div class="px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center gap-4">
                <div class="text-orange-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Stock Crítico</p>
                    <h3 class="text-lg font-black text-gray-800 leading-none">{{ $stockCritico ?? 14 }}</h3>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div class="flex gap-2">
                <a href="#" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Exportar CSV
                </a>
                
                <button id="btnAbrirModal" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors shadow-sm shadow-red-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Repuesto
                </button>
            </div>
        </div>
    </div>

    <!-- Área de la Tabla de Inventario -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-700">Listado de Repuestos Diesel</h2>
        </div>
        <div class="p-6 text-center text-gray-500 text-sm">
            <p>La tabla de inventario se renderizará aquí...</p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL NUEVO REPUESTO -->
    <!-- ========================================== -->
    <div id="modalNuevoRepuesto" class="fixed inset-0 z-50 hidden">
        <!-- Fondo Oscuro -->
        <div id="fondoModal" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Contenedor del Modal -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-xl shadow-xl text-left overflow-hidden transform transition-all sm:my-8 sm:max-w-lg w-full">
                
                <!-- Cabecera del modal -->
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Registrar Nuevo Repuesto</h3>
                    <button id="btnCerrarModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la pieza</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all" placeholder="Ej. Inyector Diesel">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Inicial</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none" value="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio ($)</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                    <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Guardar Repuesto
                    </button>
                    <button type="button" id="btnCancelar" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TOAST DE NOTIFICACIONES -->
    <!-- ========================================== -->
    <div id="toastExito" class="fixed bottom-5 right-5 z-50 hidden transform translate-y-10 opacity-0 transition-all duration-300 ease-out">
        <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span id="toastMensaje" class="font-medium text-sm">Operación realizada con éxito</span>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Lógica del Modal ---
        const modal = document.getElementById('modalNuevoRepuesto');
        const btnAbrir = document.getElementById('btnAbrirModal');
        const btnCerrar = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const fondoModal = document.getElementById('fondoModal');

        const toggleModal = () => {
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
                    modal.querySelector('.transform').classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                modal.classList.add('hidden');
            }
        };

        if (btnAbrir) btnAbrir.addEventListener('click', toggleModal);
        if (btnCerrar) btnCerrar.addEventListener('click', toggleModal);
        if (btnCancelar) btnCancelar.addEventListener('click', toggleModal);
        if (fondoModal) fondoModal.addEventListener('click', toggleModal);

        // --- Lógica del Toast (Alertas Flotantes) ---
        const toastExito = document.getElementById('toastExito');
        const toastMensaje = document.getElementById('toastMensaje');

        window.mostrarToast = (mensaje) => {
            if (toastExito && toastMensaje) {
                if (mensaje) toastMensaje.textContent = mensaje;
                
                toastExito.classList.remove('hidden');
                
                requestAnimationFrame(() => {
                    toastExito.classList.remove('translate-y-10', 'opacity-0');
                });

                setTimeout(() => {
                    toastExito.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toastExito.classList.add('hidden'), 300);
                }, 3000);
            }
        };

        @if(session('success'))
            mostrarToast("{{ session('success') }}");
        @endif
    });
</script>
@endsection