<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Empresa\SeleccionarEmpresaController;
// Removed old controller import to avoid conflict with API version
// use App\Http\Controllers\Contabilidad\CuentaContableController;
// Removed old controller import to avoid conflict with API version
// use App\Http\Controllers\Contabilidad\ComprobanteController;
use App\Http\Controllers\Api\AsientoContableController;
use App\Http\Controllers\Api\ReporteContableController;
use App\Http\Controllers\Api\CuentaContableController;
use App\Http\Controllers\Api\TerceroController;
use App\Http\Controllers\Api\ComprobanteController;
use App\Http\Controllers\Api\ImpuestoController;
use App\Http\Controllers\Api\DashboardContableController;
use App\Http\Controllers\Api\ConciliacionController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\PagoController;
use Illuminate\Support\Facades\Route;

// Rutas Públicas
Route::get('/', function () {
    // CORREGIDO: Quitar el espacio al final
    return redirect()->route('admin.dashboard');
})->name('home'); // También cambié el nombre a 'home' para que sea más claro

// Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Opcional: registro público
    // Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [AuthController::class, 'register']);
    
    // Recuperación de contraseña
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
});

// Rutas protegidas (para todos los usuarios autenticados)
Route::middleware('auth')->group(function () {
    // Logout debe estar disponible para todos los usuarios autenticados
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Panel Administrativo
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de Empresas
    Route::prefix('empresas')->name('empresas.')->group(function () {
        Route::get('/', [EmpresaController::class, 'index'])->name('index');
        Route::get('/create', [EmpresaController::class, 'create'])->name('create');
        Route::get('/listar', [EmpresaController::class, 'listar'])->name('listar');
        Route::post('/', [EmpresaController::class, 'store'])->name('store');
        Route::get('/{empresa}', [EmpresaController::class, 'show'])->name('show');
        Route::get('/{empresa}/edit', [EmpresaController::class, 'edit'])->name('edit');
        Route::put('/{empresa}', [EmpresaController::class, 'update'])->name('update');
        Route::delete('/{empresa}', [EmpresaController::class, 'destroy'])->name('destroy');
        
        // Crear esquema para empresa
        Route::post('/{empresa}/crear-esquema', [EmpresaController::class, 'crearEsquema'])->name('crear-esquema');
    });
    
    // Gestión de Usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/list', [UserController::class, 'list'])->name('list');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        
        // Asignar empresas a usuarios
        Route::post('/{user}/asignar-empresa', [UserController::class, 'asignarEmpresa'])->name('asignar-empresa');
        Route::delete('/{user}/remover-empresa/{empresa}', [UserController::class, 'removerEmpresa'])->name('remover-empresa');
    });
});

// Rutas de Empresa (requieren selección de empresa)
// Estas las puedes ir habilitando gradualmente
Route::middleware(['auth'])->group(function () {
    
    // Selección de Empresa
    // Route::get('/seleccionar-empresa', [SeleccionarEmpresaController::class, 'index'])->name('seleccionar-empresa');
    // Route::post('/seleccionar-empresa/{empresa}', [SeleccionarEmpresaController::class, 'seleccionar'])->name('seleccionar-empresa.store');
    
    // Rutas dentro de una empresa específica (usarán el esquema correspondiente)
    Route::middleware(['empresa'])->group(function () {
        
        // Dashboard de la Empresa
        // Route::get('/dashboard-empresa', [\App\Http\Controllers\Empresa\DashboardController::class, 'index'])->name('dashboard.empresa');
        
        // Módulos Contables (puedes ir descomentando según los vayas implementando)
        Route::prefix('contabilidad')->name('contabilidad.')->group(function () {
            // Cuentas Contables
            // Route::get('/cuentas', [CuentaContableController::class, 'index'])->name('cuentas.index');
            // Route::get('/cuentas/create', [CuentaContableController::class, 'create'])->name('cuentas.create');
            // Route::post('/cuentas', [CuentaContableController::class, 'store'])->name('cuentas.store');
            // Route::get('/cuentas/{cuenta}', [CuentaContableController::class, 'show'])->name('cuentas.show');
            // Route::get('/cuentas/{cuenta}/edit', [CuentaContableController::class, 'edit'])->name('cuentas.edit');
            // Route::put('/cuentas/{cuenta}', [CuentaContableController::class, 'update'])->name('cuentas.update');
            // Route::delete('/cuentas/{cuenta}', [CuentaContableController::class, 'destroy'])->name('cuentas.destroy');
            
            // Comprobantes
            // Route::get('/comprobantes', [ComprobanteController::class, 'index'])->name('comprobantes.index');
            // Route::get('/comprobantes/create', [ComprobanteController::class, 'create'])->name('comprobantes.create');
            // Route::post('/comprobantes', [ComprobanteController::class, 'store'])->name('comprobantes.store');
            // Route::get('/comprobantes/{comprobante}', [ComprobanteController::class, 'show'])->name('comprobantes.show');
            
            // Cuentas Contables API
            Route::prefix('api/cuentas')->name('api.cuentas.')->group(function () {
                Route::get('/', [CuentaContableController::class, 'index'])->name('index');
                Route::get('/hojas', [CuentaContableController::class, 'leaves'])->name('leaves');
            });

            // Terceros API
            Route::prefix('api/terceros')->name('api.terceros.')->group(function () {
                Route::get('/', [TerceroController::class, 'index'])->name('index');
                Route::get('/{id}', [TerceroController::class, 'show'])->name('show');
                Route::post('/', [TerceroController::class, 'store'])->name('store');
                Route::put('/{id}', [TerceroController::class, 'update'])->name('update');
                Route::delete('/{id}', [TerceroController::class, 'destroy'])->name('destroy');
            });

            // Asientos Contables API
            Route::prefix('api/asientos-contables')->name('api.asientos-contables.')->group(function () {
                Route::get('/', [AsientoContableController::class, 'index'])->name('index');
                Route::post('/', [AsientoContableController::class, 'store'])->name('store');
                Route::get('/{id}', [AsientoContableController::class, 'show'])->name('show');
                Route::put('/{id}', [AsientoContableController::class, 'update'])->name('update');
                Route::delete('/{id}', [AsientoContableController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/aprobar', [AsientoContableController::class, 'aprobar'])->name('aprobar');
            });

            // Comprobantes API
            Route::prefix('api/comprobantes')->name('api.comprobantes.')->group(function () {
                Route::get('/', [ComprobanteController::class, 'index'])->name('index');
                Route::get('/{id}', [ComprobanteController::class, 'show'])->name('show');
                Route::post('/', [ComprobanteController::class, 'store'])->name('store');
                Route::post('/{id}/aprobar', [ComprobanteController::class, 'aprobar'])->name('aprobar');
            });

            // Impuestos API
            Route::prefix('api/impuestos')->name('api.impuestos.')->group(function () {
                Route::get('/', [ImpuestoController::class, 'index'])->name('index');
                Route::post('/calcular', [ImpuestoController::class, 'calcular'])->name('calcular');
            });

            // Dashboard Financiero
            Route::get('api/dashboard-contable', [DashboardContableController::class, 'index'])->name('api.dashboard-contable.index');

            // Conciliación Bancaria
            Route::prefix('api/conciliacion')->name('api.conciliacion.')->group(function () {
                Route::get('/cuentas', [ConciliacionController::class, 'cuentasBancarias'])->name('cuentas');
                Route::post('/importar', [ConciliacionController::class, 'importar'])->name('importar');
                Route::get('/{id}/sugerencias', [ConciliacionController::class, 'sugerencias'])->name('sugerencias');
                Route::post('/conciliar', [ConciliacionController::class, 'conciliar'])->name('conciliar');
            });

            // Inventario
            Route::prefix('api/inventario')->name('api.inventario.')->group(function () {
                Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
                Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
                Route::get('/productos/{id}/kardex', [ProductoController::class, 'kardex'])->name('productos.kardex');
            });

            // Cuentas por Pagar / Cobrar (Pagos)
            Route::prefix('api/pagos')->name('api.pagos.')->group(function () {
                Route::get('/deudas', [PagoController::class, 'deudas'])->name('deudas');
                Route::post('/', [PagoController::class, 'store'])->name('store');
                Route::get('/historial/{id}', [PagoController::class, 'historial'])->name('historial');
            });

            // Reportes Contables
            Route::prefix('reportes')->name('reportes.')->group(function () {
                Route::get('/libro-mayor', [ReporteContableController::class, 'libroMayor'])->name('libro-mayor');
                Route::get('/balance-comprobacion', [ReporteContableController::class, 'balanceComprobacion'])->name('balance-comprobacion');
            });
        });
    });
});