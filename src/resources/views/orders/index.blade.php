@extends('layouts.admin')

@section('title', 'Order Management — Halcón')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h4 class="mb-0">Customer Orders Management</h4>
        <small class="text-muted">View, search, filter, and manage active customer orders</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">← Dashboard</a>
        @if(auth()->user()->isAdmin() || auth()->user()->hasRole('Sales') || auth()->user()->hasRole('Ventas'))
            <a href="{{ route('admin.orders.deleted') }}" class="btn btn-outline-danger btn-sm">Deleted Orders</a>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">+ Create New Order</a>
        @endif
    </div>
</div>

{{-- Filtros de búsqueda --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Invoice Number</label>
                <input type="text" name="invoice_number" value="{{ request('invoice_number') }}" class="form-control form-control-sm" placeholder="e.g. 1001">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Customer Number</label>
                <input type="text" name="customer_number" value="{{ request('customer_number') }}" class="form-control form-control-sm" placeholder="e.g. CLI-001">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Order Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach(['Ordered', 'In process', 'In route', 'Delivered'] as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-dark btn-sm w-100">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabla de pedidos activos --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer #</th>
                        <th>Customer / Company</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $badgeClass = match($order->status) {
                                'Ordered'    => 'bg-primary',
                                'In process' => 'bg-warning text-dark',
                                'In route'   => 'bg-info text-dark',
                                'Delivered'  => 'bg-success',
                                default      => 'bg-secondary',
                            };
                        @endphp
                        <tr>
                            <td class="fw-bold">#{{ $order->invoice_number }}</td>
                            <td><code>{{ $order->customer->customer_number ?? 'N/A' }}</code></td>
                            <td>{{ $order->customer->business_name ?? 'N/A' }}</td>
                            <td class="small text-muted">{{ $order->created_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ $order->status }}</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        Details / Edit
                                    </a>

                                    @if(auth()->user()->isAdmin() || auth()->user()->hasRole('Sales') || auth()->user()->hasRole('Ventas'))
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" class="m-0" onsubmit="return confirm('Move order #{{ $order->invoice_number }} to Deleted Orders?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No active orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection