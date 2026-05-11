<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Kelurahan Sambong</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-green: #1e5233; 
            --secondary-green: #2d7a4d;
            --soft-green: #f0fdf4;
            --text-dark: #111827;
            --border-color: #e5e7eb;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: radial-gradient(circle at 100% 0%, #f0fdf4 0%, transparent 25%);
        }

        .login-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        .card-header-custom {
            text-align: center;
            padding: 40px 30px 20px;
        }

        .card-header-custom img { height: 60px; margin-bottom: 20px; }
        .card-header-custom h4 { font-weight: 800; color: var(--primary-green); letter-spacing: -0.5px; }

        .form-label { font-weight: 600; font-size: 0.85rem; color: #374151; margin-bottom: 8px; }

        /* Style untuk Input Group Password */
        .input-group-text {
            background-color: #fcfcfc;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
        }

        .input-group-text:hover { color: var(--secondary-green); }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            font-size: 0.95rem;
            background-color: #fcfcfc;
        }

        .form-control.password-input { border-right: none; border-radius: 12px 0 0 12px; }

        .form-control:focus {
            border-color: var(--secondary-green);
            box-shadow: none;
            background-color: #fff;
        }

        /* Menjaga border tetap hijau saat focus pada group */
        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text {
            border-color: var(--secondary-green);
            box-shadow: 0 0 0 4px rgba(45, 122, 77, 0.1);
        }

        .btn-admin-login {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-admin-login:hover { background: var(--secondary-green); transform: translateY(-1px); }

        .footer-link {
            text-align: center;
            padding: 25px;
            background-color: #f9fafb;
            border-top: 1px solid var(--border-color);
            border-radius: 0 0 24px 24px;
        }

        .btn-back { text-decoration: none; color: #6b7280; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="login-card">
            <div class="card-header-custom">
                <img src="{{ asset('storage/img/logo_batang.png') }}" alt="Logo Batang">
                <h4>ADMIN LOGIN</h4>
                <p class="text-muted small">Kelurahan Sambong</p>
            </div>

            <div class="card-body px-4 pb-4">
                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username admin" required autofocus>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control password-input" placeholder="••••••••" required>
                            <span class="input-group-text" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-admin-login">Masuk Dashboard</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle ikon
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>