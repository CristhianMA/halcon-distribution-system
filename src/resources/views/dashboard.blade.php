@extends('layouts.admin')

@section('title', 'Administrative Dashboard — Halcón')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="mb-1">Welcome, {{ $user->name }}</h3>
            <p class="text-muted mb-0">
                Assigned Role:
                <span class="badge bg-primary">{{ $user->role->name ?? 'Unassigned' }}</span>
                • Status:
                <span class="badge bg-success">Active Employee</span>
            </p>
        </div>
        <div class="d-flex gap-3 mt-3 mt-md-0">
            <div class="border rounded px-3 py-2 bg-white text-center">
                <div class="small text-muted">Total Orders</div>
                <div class="fs-5 fw-bold">{{ $stats['total_orders'] }}</div>
            </div>
            <div class="border rounded px-3 py-2 bg-white text-center">
                <div class="small text-muted">Active Staff</div>
                <div class="fs-5 fw-bold">{{ $stats['active_employees'] }}</div>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3 fw-semibold">Available Modules for Your Role</h5>

<div class="row g-3">
    @if($user->isAdmin())
        <div class="col-md-4">
            <div class="card h-100 border-primary shadow-sm">
                <div class="card-body">
                    <span class="badge bg-primary mb-2">Administrator</span>
                    <h5 class="card-title">User & Role Management</h5>
                    <p class="card-text text-muted small">Register employees, edit staff profiles, assign roles, and activate or deactivate accounts.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">Manage Users</a>
                </div>
            </div>
        </div>
    @endif

    @if($user->hasRole('Sales') || $user->hasRole('Ventas') || $user->isAdmin())
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <span class="badge bg-success mb-2">Sales</span>
                    <h5 class="card-title">Customer Orders</h5>
                    <p class="card-text text-muted small">Create and manage customer orders and monitor invoice statuses.</p>
                    <a href="{{ route('modules.sales') }}" class="btn btn-outline-success btn-sm">Open Sales Module</a>
                </div>
            </div>
        </div>
    @endif

    @if($user->hasRole('Purchasing') || $user->hasRole('Compras') || $user->isAdmin())
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <span class="badge bg-warning text-dark mb-2">Purchasing</span>
                    <h5 class="card-title">Missing Materials Support</h5>
                    <p class="card-text text-muted small">Support orders requiring procurement of missing materials.</p>
                    <a href="{{ route('modules.purchasing') }}" class="btn btn-outline-warning text-dark btn-sm">Open Purchasing Module</a>
                </div>
            </div>
        </div>
    @endif

    @if($user->hasRole('Warehouse') || $user->hasRole('Almacén') || $user->hasRole('Almacen') || $user->isAdmin())
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <span class="badge bg-info text-dark mb-2">Warehouse</span>
                    <h5 class="card-title">Order Preparation</h5>
                    <p class="card-text text-muted small">Process and prepare customer orders for dispatch.</p>
                    <a href="{{ route('modules.warehouse') }}" class="btn btn-outline-info text-dark btn-sm">Open Warehouse Module</a>
                </div>
            </div>
        </div>
    @endif

    @if($user->hasRole('Route') || $user->hasRole('Ruta') || $user->isAdmin())
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2">Route</span>
                    <h5 class="card-title">Routed Orders & Delivery</h5>
                    <p class="card-text text-muted small">Manage routed orders and upload delivery evidence.</p>
                    <a href="{{ route('modules.route') }}" class="btn btn-outline-secondary btn-sm">Open Route Module</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection