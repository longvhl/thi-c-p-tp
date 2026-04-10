<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BikeGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0ea5e9;
            --primary-pink: #ec4899;
            --sidebar-width: 260px;
        }
        body {
            background-color: #f8fafc;
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--primary-blue) 0%, #0369a1 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 4px 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        .sidebar .sidebar-brand {
            padding: 24px 20px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }
        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        .btn-primary:hover {
            background-color: #0284c7;
            border-color: #0284c7;
        }
        .badge-available { background-color: #10b981; }
        .badge-rented { background-color: #f59e0b; }
        .badge-maintenance { background-color: #ef4444; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            BikeGo Admin
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.bikes.*') ? 'active' : '' }}" href="{{ route('admin.bikes.index') }}">
                    <i class="fa fa-bicycle me-2"></i> Quản lý xe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.stations.*') ? 'active' : '' }}" href="{{ route('admin.stations.index') }}">
                    <i class="fa fa-map-marker-alt me-2"></i> Quản lý trạm xe
                </a>
            </li>
            <li class="nav-item mt-auto">
                <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h4 class="mb-0">@yield('page-title', 'Admin Dashboard')</h4>
            <div class="user-info">
                <span class="fw-bold">Administrator</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=0ea5e9&color=fff" class="rounded-circle ms-2" width="40">
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
