<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login — Halcón Distribution System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">HALCÓN</h4>
                        <small class="text-secondary">Employee Administrative Access</small>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Employee Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="admin@halcon.com"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="••••••••"
                                    required
                                >
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary fw-semibold">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white text-center py-3">
                        <small class="text-muted d-block mb-1">Authorized personnel only. Customer registration is disabled.</small>
                        <a href="{{ route('home') }}" class="text-decoration-none small">← Back to Public Order Tracking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>