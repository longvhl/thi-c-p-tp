@extends('layouts.client')

@section('title', 'Vũ Hoàng Long PTW.B23')

@section('content')
<div class="container mt-4 pb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-theme-blue text-white py-3">
            <h5 class="mb-0"><i class="fa fa-route"></i> Chuyến đi hiện tại (Active Ride)</h5>
        </div>
        <div class="card-body p-4 text-center">
            
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

            @if(!$rental)
                <i class="fa fa-bed fa-4x text-muted mb-3"></i>
                <h4 class="fw-bold text-dark">Bạn không có chuyến đi nào đang diễn ra!</h4>
                <div class="mt-4">
                    <a href="/rental" class="btn btn-theme rounded-pill p-2 px-4 shadow"><i class="fa fa-bicycle"></i> Thuê xe ngay</a>
                </div>
            @else
                <i class="fa fa-bicycle fa-4x text-theme-pink mb-3"></i>
                <h4 class="fw-bold text-dark">Đang khởi hành</h4>
                <p class="text-muted">Bạn đã thuê: <strong>{{ $rental->bike_type }}</strong> (BS: {{ $rental->bike_number }})</p>
                
                <div class="row justify-content-center mt-4">
                    <div class="col-md-7">
                        <ul class="list-group text-start shadow-sm">
                            <li class="list-group-item"><strong>Trạm xuất phát:</strong> {{ $rental->station_start }}</li>
                            <li class="list-group-item"><strong>Biển số xe:</strong> {{ $rental->bike_number }}</li>
                            <li class="list-group-item"><strong>Giờ nhận xe:</strong> {{ $rental->start_time->format('H:i - d/m/Y') }}</li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Thời gian đã thuê:</strong>
                                <span id="elapsedTime" data-start="{{ $rental->start_time->toIso8601String() }}">0 phút</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-warning">
                                <strong>Số tiền tạm tính:</strong>
                                <span id="currentCost" data-price="{{ $rental->unit_price }}">0đ</span>
                            </li>
                            <li class="list-group-item"><strong>Trạng thái:</strong> <span class="badge bg-success">Đang hoạt động</span></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="/payment" class="btn btn-theme rounded-pill fw-bold p-2 px-4 shadow">Kết thúc & Trả xe</a>
                </div>

                @push('scripts')
                <script>
                    function updateRideInfo() {
                        const startTime = new Date(document.getElementById('elapsedTime').dataset.start);
                        const unitPrice = parseFloat(document.getElementById('currentCost').dataset.price);
                        
                        const now = new Date();
                        const diffMs = now - startTime;
                        const diffMins = Math.max(0, Math.floor(diffMs / 60000));
                        
                        document.getElementById('elapsedTime').innerText = diffMins + ' phút';
                        
                        // Cost = 5000 base + (minutes * unitPrice)
                        const cost = 5000 + (diffMins * unitPrice);
                        document.getElementById('currentCost').innerText = new Intl.NumberFormat('vi-VN').format(cost) + 'đ';
                    }
                    
                    setInterval(updateRideInfo, 10000); // Update every 10s
                    updateRideInfo();
                </script>
                @endpush
            @endif
        </div>
    </div>
</div>
@endsection
