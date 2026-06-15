<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SI Bansos Desa Lamong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-card { max-width: 400px; margin: 100px auto; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card login-card shadow-sm">
            <div class="card-body p-4">
                <h4 class="text-center mb-4">Login SI Bansos</h4>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/login" method="POST">
                    @csrf 
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                                <i class="bi bi-eye-fill" id="eyeIconLogin"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Masuk</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                Desa Lamong &copy; 2026
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnTogglePassword').addEventListener('click', function() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eyeIconLogin');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                pwd.type = 'password';
                icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        });
    </script>
</body>
</html>