@extends('layouts.admin')

@section('title', 'Deleted Orders — Halcón')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h4 class="mb-0 text-danger">Deleted Orders (Soft-Deleted Archive)</h4>
        <small class="text-muted">Search, edit, or restore logically deleted orders back to the active list</small>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Active Orders</a>
</div>

{{-- Buscador en pedidos eliminados --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.deleted') }}" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label small fw-semibold mb-1">Search Deleted Order</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by Invoice #, Customer #, or Company Name...">
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-dark btn-sm w-100">Search</button>
                <a href="{{ route('admin.orders.deleted') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            </div>
        </form>
    </div>
</div>

{{-- Lista de pedidos eliminados --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Delivery Address & Notes</th>
                        <th>Deleted At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deletedOrders as $order)
                        <tr>
                            <td class="fw-bold">#{{ $order->invoice_number }}</td>
                            <td>
                                <div class="fw-semibold">{{ $order->customer->business_name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $order->customer->customer_number ?? '' }}</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                            <td class="small">
                                <div>{{ $order->delivery_address }}</div>
                                @if($order->notes)
                                    <div class="text-muted">Note: {{ $order->notes }}</div>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $order->deleted_at?->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    {{-- Botón para desplegar edición rápida --}}
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#editDeleted{{ $order->id }}">
                                        Edit
                                    </button>

                                    {{-- Restaurar pedido --}}
                                    <form method="POST" action="{{ route('admin.orders.restore', $order->id) }}" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="collapse bg-light" id="editDeleted{{ $order->id }}">
                            <td colspan="6">
                                <form method="POST" action="{{ route('admin.orders.update-trashed', $order->id) }}" class="row g-2 align-items-end p-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-2">
                                        <label class="form-label small fw-semibold mb-1">Status</label>
                                        <select name="status" class="form-select form-select-sm">
                                            @foreach(['Ordered', 'In process', 'In route', 'Delivered'] as $st)
                                                <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small fw-semibold mb-1">Delivery Address</label>
                                        <input type="text" name="delivery_address" value="{{ $order->delivery_address }}" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold mb-1">Notes</label>
                                        <input type="text" name="notes" value="{{ $order->notes }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">Update Deleted</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No deleted orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $deletedOrders->links() }}
        </div>
    </div>
</div>
@endsection