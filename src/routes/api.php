<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

// Rutas específicas para órdenes (deben ir antes del resource)
Route::get('orders/archived', [OrderController::class, 'archived']);
Route::get('orders/invoice/{invoice}', [OrderController::class, 'searchByInvoice']);
Route::post('orders/track', [OrderController::class, 'trackOrder']);

// Rutas RESTful completas para Usuarios y Órdenes
Route::apiResource('users', UserController::class);
Route::apiResource('orders', OrderController::class);