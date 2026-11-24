<?php

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