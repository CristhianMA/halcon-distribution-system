@extends('layouts.admin')

@section('title', "Order #{$order->invoice_number} Details — Halcón")

@section('content')
@php
    $canEditCustomerAndAddress = auth()->user()->isAdmin() || auth()->user()->hasRole('Sales') || auth()->user()->hasRole('Ventas');
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">Order Details — Invoice #{{ $order->invoice_number }}</h4>
        <small class="text-muted">Created on {{ $order->created_at?->format('Y-m-d H:i') }} by {{ $order->user->name ?? 'System' }}</small>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Orders</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-4">
                <label class="form-label fw-semibold">Invoice Number</label>
                <input type="text" class="form-control bg-light" value="#{{ $order->invoice_number }}" readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Unique Customer Number</label>
                <input type="text" class="form-control bg-light" value="{{ $order->customer->customer_number ?? '' }}" readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Current Order Status *</label>
                <select name="status" class="form-select fw-semibold" required>
                    @foreach(['Ordered', 'In process', 'In route', 'Delivered'] as $st)
                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Customer / Company Name</label>
                <input type="text" name="business_name" value="{{ old('business_name', $order->customer->business_name ?? '') }}" class="form-control {{ $canEditCustomerAndAddress ? '' : 'bg-light' }}" {{ $canEditCustomerAndAddress ? 'required' : 'readonly' }}>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Customer Fiscal Information</label>
                <input type="text" name="tax_data" value="{{ old('tax_data', $order->customer->tax_data ?? '') }}" class="form-control {{ $canEditCustomerAndAddress ? '' : 'bg-light' }}" {{ $canEditCustomerAndAddress ? 'required' : 'readonly' }}>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Delivery Address</label>
                <textarea name="delivery_address" rows="2" class="form-control {{ $canEditCustomerAndAddress ? '' : 'bg-light' }}" {{ $canEditCustomerAndAddress ? 'required' : 'readonly' }}>{{ old('delivery_address', $order->delivery_address) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Notes or Additional Information</label>
                <textarea name="notes" rows="2" class="form-control">{{ old('notes', $order->notes) }}</textarea>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection