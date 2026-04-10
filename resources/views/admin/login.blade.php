<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BikeGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0ea5e9;
            --primary-pink: #ec4899;
        }
        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #fdf2f8 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
        }
        .login-card h2 {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            border-color: var(--primary-blue);
        }
        .btn-login {
            background: linear-gradient(to right, var(--primary-blue), var(--primary-pink));
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            opacity: 0.9;
            color: white;
        }
        .alert {
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>BikeGo Admin</h2>
        
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fa fa-user text-muted"></i></span>
                    <input type="text" name="username" class="form-control border-start-0" placeholder="admin" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fa fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="•••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-login">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
