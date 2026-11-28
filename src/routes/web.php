<?php

use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Customer Order Tracking Screen
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Employee Authentication Routes (No public registration allowed)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Authenticated Employee Routes
Route::middleware('auth')->group(function () {
    // Administrative Dashboard (Accessible by any active employee)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Administrator Only: User & Role Management CRUD
    Route::middleware('role:Admin,Administrator')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        });

    // Order Management Module (Activity 14)
    Route::prefix('orders')->name('admin.orders.')->group(function () {
        // Lista de pedidos activos y búsqueda/filtros
        Route::get('/', [OrderManagementController::class, 'index'])->name('index');

        // Solo Admin y Ventas pueden crear, ver eliminados, editar eliminados, restaurar y borrar
        Route::middleware('role:Admin,Administrator,Sales,Ventas')->group(function () {
            Route::get('/create', [OrderManagementController::class, 'create'])->name('create');
            Route::post('/', [OrderManagementController::class, 'store'])->name('store');
            Route::get('/deleted', [OrderManagementController::class, 'trashed'])->name('deleted');
            Route::put('/{id}/update-trashed', [OrderManagementController::class, 'updateTrashed'])->name('update-trashed');
            Route::patch('/{id}/restore', [OrderManagementController::class, 'restore'])->name('restore');
            Route::delete('/{id}', [OrderManagementController::class, 'destroy'])->name('destroy');
        });

        // Detalle y edición según permisos del rol logueado
        Route::get('/{id}', [OrderManagementController::class, 'show'])->name('show');
        Route::put('/{id}', [OrderManagementController::class, 'update'])->name('update');
    });

    // Role-Specific Operational Modules
    Route::get('/modules/sales', [DashboardController::class, 'module'])
        ->defaults('module', 'sales')
        ->middleware('role:Sales,Ventas,Admin,Administrator')
        ->name('modules.sales');

    Route::get('/modules/purchasing', [DashboardController::class, 'module'])
        ->defaults('module', 'purchasing')
        ->middleware('role:Purchasing,Compras,Admin,Administrator')
        ->name('modules.purchasing');

    Route::get('/modules/warehouse', [DashboardController::class, 'module'])
        ->defaults('module', 'warehouse')
        ->middleware('role:Warehouse,Almacén,Almacen,Admin,Administrator')
        ->name('modules.warehouse');

    Route::get('/modules/route', [DashboardController::class, 'module'])
        ->defaults('module', 'route')
        ->middleware('role:Route,Ruta,Admin,Administrator')
        ->name('modules.route');
});