@extends('admin.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="fa fa-bicycle text-primary fs-3" style="width: 30px; text-align: center;"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold">{{ $totalBikes }}</h2>
                    <p class="text-muted mb-0">Tổng số xe</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="fa fa-map-marker-alt text-warning fs-3" style="width: 30px; text-align: center;"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold">{{ $totalStations }}</h2>
                    <p class="text-muted mb-0">Tổng số trạm</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Chào mừng trở lại, Admin!</h5>
            </div>
            <div class="card-body">
                <p>Hệ thống quản lý BikeGo đang hoạt động bình thường. Bạn có thể sử dụng sidebar để quản lý xe và các trạm.</p>
                <div class="alert alert-info border-0 shadow-none">
                    <i class="fa fa-info-circle me-2"></i> Mẹo: Nhấp vào "Quản lý xe" để xem danh sách xe và tình trạng hiện tại.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
