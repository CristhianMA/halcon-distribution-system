@extends('layouts.admin')

@section('title', 'Create New Order — Halcón')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">Create New Order</h4>
        <small class="text-muted">New orders are automatically initialized with status <strong>Ordered</strong></small>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Orders</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.orders.store') }}" class="row g-3">
            @csrf

            <div class="col-md-4">
                <label class="form-label fw-semibold">Consecutive Invoice Number *</label>
                <input type="number" name="invoice_number" value="{{ old('invoice_number', $nextInvoice) }}" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Unique Customer Number *</label>
                <input type="text" name="customer_number" list="existingCustomers" value="{{ old('customer_number') }}" class="form-control" placeholder="e.g. CLI-001" required>
                <datalist id="existingCustomers">
                    @foreach($customers as $c)
                        <option value="{{ $c->customer_number }}">{{ $c->business_name }}</option>
                    @endforeach
                </datalist>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Initial Status</label>
                <input type="text" class="form-control bg-light fw-bold text-primary" value="Ordered" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Customer / Company Name *</label>
                <input type="text" name="business_name" value="{{ old('business_name') }}" class="form-control" placeholder="e.g. Constructora del Norte S.A." required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Order Date & Time</label>
                <input type="datetime-local" name="created_at" value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Customer Fiscal Information (RFC / Tax Data) *</label>
                <textarea name="tax_data" rows="2" class="form-control" placeholder="RFC, Razón Social, Régimen Fiscal, Uso CFDI..." required>{{ old('tax_data') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Delivery Address *</label>
                <textarea name="delivery_address" rows="2" class="form-control" placeholder="Street, number, neighborhood, city, zip code..." required>{{ old('delivery_address') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Notes or Additional Information</label>
                <textarea name="notes" rows="2" class="form-control" placeholder="Delivery instructions, material details, contact person...">{{ old('notes') }}</textarea>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Order (Status: Ordered)</button>
            </div>
        </form>
    </div>
</div>
@endsection