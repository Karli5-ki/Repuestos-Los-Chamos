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
    Route::view('/facturacion', 'admin.facturacion')->name('facturacion.index');

    Route::get('/inventario', function () {
        $repuestos = [];
        return view('admin.inventario', compact('repuestos'));
    })->name('inventario.index');

    Route::get('/catalogo', function () {
        $repuestos = []; 
        return view('admin.catalogo', compact('repuestos'));
    })->name('catalogo');

    Route::get('/usuarios', function () {
        $usuarios = [];
        return view('admin.usuarios', compact('usuarios'));
    })->name('usuarios.index');

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
    
    Route::view('/facturacion', 'ventas.facturacion')->name('facturacion');
    Route::view('/cotizacion', 'ventas.cotizacion')->name('cotizacion');
    Route::view('/cotizacion/create', 'ventas.cotizacion')->name('cotizacion.create');
    
    Route::match(['post', 'delete'], '/cotizacion/vaciar', function () { 
        return redirect()->route('ventas.cotizacion'); 
    })->name('cotizacion.vaciar');

    Route::post('/cotizacion/guardar', function () { 
        return redirect()->route('ventas.cotizacion'); 
    })->name('cotizacion.guardar');

    Route::get('/corte-caja', function () { return "Vista de Corte de Caja"; })->name('corte_caja');
    
    // Rutas unificadas y limpias para Catálogo e Inventario en Ventas
    Route::get('/catalogo', function () {
        $repuestos = []; 
        return view('admin.catalogo', compact('repuestos'));
    })->name('catalogo');

    Route::get('/inventario/consulta', function () {
        $repuestos = [];
        return view('admin.inventario', compact('repuestos'));
    })->name('inventario.consulta');
});