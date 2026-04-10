<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - BikeGo')</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Admin Navbar -->
    <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/"><i class="fa fa-cogs"></i> Admin Control Panel</a>
            <div class="text-white">Admin</div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-white shadow-sm" style="min-height: 80vh; border-radius: 8px;">
                <ul class="nav flex-column py-3 fw-bold">
                    <li class="nav-item"><a class="nav-link text-dark" href="#"><i class="fa fa-tachometer-alt text-primary"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#"><i class="fa fa-users text-primary"></i> Users</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#"><i class="fa fa-bicycle text-primary"></i> Bikes</a></li>
                </ul>
            </div>
            <!-- Main Content Area -->
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
