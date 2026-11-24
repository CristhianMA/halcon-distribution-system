@extends('layouts.admin')

@section('title', $title . ' — Halcón')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">{{ $title }}</h4>
        <small class="text-muted">Logged in as {{ $user->name }} ({{ $user->role->name }})</small>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">← Back to Dashboard</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->invoice_number }}</td>
                            <td>{{ $order->customer->name ?? 'N/A' }} ({{ $order->customer->customer_number ?? '' }})</td>
                            <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                            <td class="text-muted small">{{ $order->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No orders available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection