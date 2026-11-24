@extends('layouts.admin')

@section('title', 'User Management — Halcón')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h4 class="mb-0">Employee & Role Management</h4>
        <small class="text-muted">Register employees, assign roles, and manage account status</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">← Dashboard</a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Register New Employee</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Assigned Role</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td class="fw-semibold">{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $employee->role->name ?? 'Unassigned' }}
                                </span>
                            </td>
                            <td>
                                @if($employee->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.users.edit', $employee) }}" class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>

                                    @if(auth()->id() !== $employee->id)
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $employee) }}" class="m-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $employee->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                                {{ $employee->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection