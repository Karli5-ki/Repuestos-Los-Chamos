<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta - Repuestos Los Chamos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex h-screen overflow-hidden text-gray-800 font-sans selection:bg-red-600 selection:text-white">

    <!-- MENÚ LATERAL (Rol: Ventas - CORREGIDO) -->
    <aside class="w-64 bg-black text-white flex flex-col h-screen overflow-y-auto border-r border-gray-900 z-20 shrink-0">
        <div class="h-20 flex items-center justify-center border-b border-red-600 shrink-0 gap-3 px-4 bg-black">
            <img src="../logo.png" alt="Logo" class="w-10 h-10 object-contain">
            <h1 class="text-sm font-bold text-white uppercase tracking-wider leading-tight">
                Los Chamos <br><span class="text-red-500 text-xs tracking-widest">Diesel</span>
            </h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-6">
            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Mi Espacio</p>
                <div class="space-y-1">
                   <a href="{{ route('ventas.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="text-sm font-medium">Panel Comercial</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Operaciones</p>
                <div class="space-y-1">
                    <a href="cotizacion.html" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-sm font-medium">Nueva Cotización</span>
                    </a>
                    <!-- BOTÓN ACTIVO -->
                    <a href="facturacion.html" class="flex items-center gap-3 px-4 py-2 rounded-md bg-red-600 text-white font-medium transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-sm font-medium">Facturación (POS)</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Consultas</p>
                <div class="space-y-1">
                    <a href="{{ route('ventas.inventario.consulta') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="text-sm font-medium">Buscar Repuestos</span>
                    </a>
                    <a href="{{ route('ventas.catalogo') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-900 text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        <span class="text-sm font-medium">Catálogo Visual</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <div class="p-4 border-t border-gray-900 bg-gray-950">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-blue-900 border border-blue-700 flex items-center justify-center text-blue-200 font-bold text-xs">M</div>
                <div>
                    <p class="text-xs font-bold text-gray-200">María Pérez</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Ventas (Caja 01)</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
        
        <!-- BARRA SUPERIOR MINIMALISTA -->
        <header class="h-14 flex items-center px-6 justify-between shrink-0 border-b border-gray-200 bg-white sticky top-0 z-10">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Punto de Venta (Mostrador)
            </h2>
            
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Caja 01 - Activa
                </div>
                
                <div class="pl-5 border-l border-gray-200">
                    <form action="../login.html" method="GET" class="inline">
                        <button type="submit" class="text-xs text-gray-500 hover:text-red-600 transition flex items-center gap-1">Salir</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- CONTENIDO DEL MÓDULO (Split Screen Limpio) -->
        <div class="flex-1 flex overflow-hidden">
            
            <!-- LADO IZQUIERDO: Buscador y Lista de Productos -->
            <div class="flex-1 flex flex-col h-full border-r border-gray-200 bg-white">
                
                <div class="p-5 border-b border-gray-100 shrink-0">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" autofocus placeholder="Buscar repuesto por SKU, nombre o marca..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded text-sm text-gray-800 focus:bg-white focus:border-red-500 outline-none transition placeholder-gray-400">
                    </div>
                    
                    <div class="flex gap-2 mt-3">
                        <button class="bg-gray-800 text-white px-3 py-1 rounded text-[11px] font-medium">Todos</button>
                        <button class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 px-3 py-1 rounded text-[11px] font-medium transition">Filtros</button>
                        <button class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 px-3 py-1 rounded text-[11px] font-medium transition">Inyección</button>
                        <button class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 px-3 py-1 rounded text-[11px] font-medium transition">Frenos</button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <div class="grid grid-cols-12 gap-4 px-5 py-2 border-b border-gray-100 bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest sticky top-0">
                        <div class="col-span-2">SKU</div>
                        <div class="col-span-6">Descripción</div>
                        <div class="col-span-2 text-center">Stock</div>
                        <div class="col-span-2 text-right">Precio</div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <!-- Producto 1 -->
                        <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center hover:bg-blue-50/30 transition group cursor-pointer">
                            <div class="col-span-2 font-mono text-xs text-gray-500">FIL-045</div>
                            <div class="col-span-6">
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
                            <div class="col-span-2 font-mono text-xs text-gray-500">INY-112</div>
                            <div class="col-span-6">
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

                        <!-- Producto 3 -->
                        <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center hover:bg-blue-50/30 transition group cursor-pointer">
                            <div class="col-span-2 font-mono text-xs text-gray-500">COR-88</div>
                            <div class="col-span-6">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors">Correa de Tiempo Isuzu</p>
                                <p class="text-[10px] text-gray-400">NPR 4HG1</p>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100">8</span>
                            </div>
                            <div class="col-span-2 text-right flex flex-col items-end gap-1">
                                <span class="text-sm font-bold text-gray-900">$32.00</span>
                                <button class="text-[10px] font-bold text-red-600 opacity-0 group-hover:opacity-100 transition flex items-center gap-1">
                                    Añadir <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Producto Agotado -->
                        <div class="grid grid-cols-12 gap-4 px-5 py-3 items-center opacity-60 bg-gray-50 cursor-not-allowed">
                            <div class="col-span-2 font-mono text-xs text-gray-400">ACE-001</div>
                            <div class="col-span-6">
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

                    </div>
                </div>
            </div>

            <!-- LADO DERECHO: Factura / Caja -->
            <div class="w-[400px] shrink-0 bg-gray-50 flex flex-col h-full">
                
                <div class="px-5 py-4 border-b border-gray-200 bg-white flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">Ticket en curso</h3>
                        <p class="text-[10px] text-gray-400 font-mono">ID: #001045</p>
                    </div>
                    <button class="text-[10px] text-gray-400 hover:text-red-600 transition flex items-center gap-1 border border-gray-200 px-2 py-1 rounded bg-white">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Vaciar
                    </button>
                </div>

                <div class="p-5 border-b border-gray-200 bg-white">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Cliente</label>
                    <div class="flex gap-2 mb-2">
                        <select class="w-16 bg-white border border-gray-300 rounded text-xs px-1 py-1.5 outline-none focus:border-gray-400">
                            <option>V-</option>
                            <option>J-</option>
                        </select>
                        <input type="text" placeholder="Documento" class="flex-1 bg-white border border-gray-300 rounded text-xs px-2 py-1.5 outline-none focus:border-gray-400 font-mono">
                        <button class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-600 px-3 rounded transition flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                    <input type="text" placeholder="Nombre o Razón Social..." class="w-full bg-white border border-gray-300 rounded text-xs px-3 py-2 outline-none focus:border-gray-400">
                </div>

                <div class="flex-1 overflow-y-auto p-2 bg-white">
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
                </div>

                <div class="p-5 border-t border-gray-200 bg-white">
                    <div class="space-y-1 mb-4 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span class="text-gray-800 font-medium">$83.00</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>IVA (16%)</span>
                            <span class="text-gray-800 font-medium">$13.28</span>
                        </div>
                        <div class="flex justify-between items-end pt-3 border-t border-gray-100 mt-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total</span>
                            <span class="text-3xl font-black text-gray-900 leading-none">$96.28</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded text-sm transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Cobrar Exacto
                    </button>
                    
                    <a href="cotizacion.html" class="block w-full mt-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded text-xs transition-colors text-center">
                        Generar Presupuesto
                    </a>
                </div>
            </div>
        </div>
        
    </main>

</body>
</html>