@extends('layouts.client')

@section('title', 'Vũ Hoàng Long PTW.B23')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row">
        <!-- Sidebar Menu User -->
        <div class="col-md-3 mb-4">
            <div class="list-group shadow-sm border-0">
                <a href="/dashboard" class="list-group-item list-group-item-action active bg-theme-blue border-0 fw-bold"><i class="fa fa-user"></i> Tổng quan (Dashboard)</a>
                <a href="/active" class="list-group-item list-group-item-action"><i class="fa fa-bicycle text-theme-pink"></i> Chuyến đi hiện tại</a>
                <a href="/history" class="list-group-item list-group-item-action"><i class="fa fa-history text-theme-pink"></i> Lịch sử thuê xe</a>
                <a href="/payment" class="list-group-item list-group-item-action"><i class="fa fa-credit-card text-theme-pink"></i> Thanh toán / Trả xe</a>
                
                <form method="POST" action="{{ route('logout') }}" id="logout-form-dashboard" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="list-group-item list-group-item-action text-danger fw-bold" onclick="event.preventDefault(); document.getElementById('logout-form-dashboard').submit();">
                    <i class="fa fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>

        <!-- Main User Panel -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4>Chào mừng, {{ $user->name }}!</h4>
                    <p class="text-muted">Email: <strong>{{ $user->email }}</strong></p>
                </div>
            </div>

            <!-- Stats Boxes -->
            <div class="row text-center mb-4">
                <div class="col-md-6 mb-3">
                    <div class="bg-light p-4 rounded-3 shadow-sm border-start border-primary border-4">
                        <i class="fa fa-route fa-2x text-theme-blue mb-2"></i>
                        <h5>Tổng chuyến đi</h5>
                        <h3 class="fw-bold">{{ $totalTrips }}</h3>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="bg-light p-4 rounded-3 shadow-sm border-start border-pink border-4">
                        <i class="fa fa-clock fa-2x text-theme-pink mb-2"></i>
                        <h5>Thời gian thuê</h5>
                        <h3 class="fw-bold">{{ $timeString }}</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
