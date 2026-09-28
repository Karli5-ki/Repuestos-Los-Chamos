<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Rutas Web - Repuestos Los Chamos
|--------------------------------------------------------------------------
*/

// --- AUTENTICACIÓN ---
Route::view('/', 'login')->name('login');
Route::post('/login', function () { 
    return redirect()->route('admin.dashboard'); 
})->name('login.procesar');
Route::post('/logout', function () { return redirect('/'); })->name('logout');


// =================================================================
// PANEL DE ADMINISTRACIÓN
// =================================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    
    // Rutas de Facturación / POS
    Route::view('/facturacion', 'admin.facturacion')->name('facturacion.index');
    
    Route::post('/facturacion/agregar', function (Request $request) {
        return back();
    })->name('facturacion.agregar');

    Route::delete('/facturacion/vaciar', function () {
        return back();
    })->name('facturacion.vaciar');

    Route::patch('/facturacion/restar/{id}', function ($id) {
        return back();
    })->name('facturacion.restar');

    Route::patch('/facturacion/sumar/{id}', function ($id) {
        return back();
    })->name('facturacion.sumar');

    Route::post('/facturacion/cobrar', function () {
        return back();
    })->name('facturacion.cobrar');

    Route::post('/facturacion/presupuesto', function () {
        return back();
    })->name('facturacion.presupuesto');

    // Inventario
    Route::get('/inventario', function () {
        $repuestos = []; 
        $stockCritico = 0; 
        return view('admin.inventario', compact('repuestos', 'stockCritico'));
    })->name('inventario.index');

    Route::post('/inventario', function (Request $request) {
        return redirect()->route('admin.inventario.index')->with('success', 'Repuesto registrado exitosamente.');
    })->name('inventario.store');

    // Catálogo
    Route::get('/catalogo', function () {
        $repuestos = []; 
        return view('admin.catalogo', compact('repuestos'));
    })->name('catalogo');

    // --- USUARIOS (Con closures / sin controladores) ---
    Route::get('/usuarios', function (Request $request) {
        $usuarios = []; 
        $cuentasActivas = 0;
        $cuentasSuspendidas = 0;
        $usuariosEnLinea = 0;
        $bitacora = [];
        return view('admin.usuarios', compact('usuarios', 'cuentasActivas', 'cuentasSuspendidas', 'usuariosEnLinea', 'bitacora'));
    })->name('usuarios.index');

    Route::view('/usuarios/crear', 'admin.usuarios-create')->name('usuarios.create');

    Route::post('/usuarios', function (Request $request) {
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario registrado exitosamente.');
    })->name('usuarios.store');

    Route::get('/usuarios/{id}/editar', function ($id) {
        return "Vista de edición para el usuario ID: " . $id;
    })->name('usuarios.edit');

    Route::put('/usuarios/{id}', function (Request $request, $id) {
        return redirect()->route('admin.usuarios.index');
    })->name('usuarios.update');

    Route::delete('/usuarios/{id}', function ($id) {
        return redirect()->route('admin.usuarios.index');
    })->name('usuarios.destroy');

    Route::post('/usuarios/{id}/logout-force', function ($id) {
        return back()->with('success', 'Sesión cerrada forzosamente.');
    })->name('usuarios.logout_force');

    // --- BITÁCORA ---
    Route::get('/bitacora', function () {
        return "Vista de historial completo de la bitácora";
    })->name('bitacora.index');

    // Proveedores
    Route::get('/proveedores', function () {
        $proveedores = []; 
        return view('admin.proveedores', compact('proveedores'));
    })->name('proveedores.index');
    
    Route::view('/proveedores/create', 'admin.proveedores-create')->name('proveedores.create');
});


// =================================================================
// PANEL DE ALMACÉN
// =================================================================
Route::prefix('almacen')->name('almacen.')->group(function () {
    Route::get('/', function () {
        $repuestos = [];
        $entradasData = [120, 0, 45, 0, 200, 10, 50]; 
        $salidasData = [35, 42, 58, 40, 65, 20, 15];  
        return view('almacen.dashboard_almacen', compact('repuestos', 'entradasData', 'salidasData'));
    })->name('dashboard');

    Route::get('/reporte', function () { return "Reporte de almacén"; })->name('reporte');
    Route::get('/recepcion/create', function () { return "Recepción de pedido"; })->name('recepcion.create');
    Route::get('/orden-compra/create', function () { return "Generar orden de compra"; })->name('orden_compra.create');

    Route::get('/inventario', function () {
        $repuestos = [];
        return view('admin.inventario', compact('repuestos'));
    })->name('inventario.index');

    Route::get('/catalogo', function () {
        $repuestos = []; 
        return view('admin.catalogo', compact('repuestos'));
    })->name('catalogo');
});


// =================================================================
// PANEL DE VENTAS
// =================================================================
Route::prefix('ventas')->name('ventas.')->group(function () {
    Route::get('/', function () {
        $ventas = [];
        $ventasSemana = [210, 350, 290, 420, 435, 0, 0];
        
        return view('ventas.dashboard_ventas', compact('ventas', 'ventasSemana'));
    })->name('dashboard');
    
    // Cambiado de Route::view a Route::get para enviar variables dinámicas
    Route::get('/facturacion', function (Request $request) {
        $productos = []; // Aquí cargarás tu modelo: Repuesto::all();
        $carrito = [];   // Aquí los ítems agregados al ticket actual
        $subtotal = 0.00;
        $iva = 0.00;
        $total = 0.00;
        
        return view('ventas.facturacion', compact('productos', 'carrito', 'subtotal', 'iva', 'total'));
    })->name('facturacion');

    Route::view('/cotizacion', 'ventas.cotizacion')->name('cotizacion');
    Route::view('/cotizacion/create', 'ventas.cotizacion')->name('cotizacion.create');
    
    Route::match(['post', 'delete'], '/cotizacion/vaciar', function () { 
        return redirect()->route('ventas.cotizacion'); 
    })->name('cotizacion.vaciar');

    Route::post('/cotizacion/guardar', function () { 
        return redirect()->route('ventas.cotizacion'); 
    })->name('cotizacion.guardar');

    Route::get('/corte-caja', function () { return "Vista de Corte de Caja"; })->name('corte_caja');
    
    Route::get('/catalogo', function () {
        $repuestos = []; 
        return view('admin.catalogo', compact('repuestos'));
    })->name('catalogo');

    Route::get('/inventario/consulta', function () {
        $repuestos = [];
        return view('admin.inventario', compact('repuestos'));
    })->name('inventario.consulta');
});

// Rutas por defecto
Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';