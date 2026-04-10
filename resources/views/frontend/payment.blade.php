@extends('layouts.client')
@section('title', 'Vũ Hoàng Long PTW.B23')
@section('content')
<div class="container mt-4" style="min-height: 60vh;">

    <div class="card shadow-sm">

        <!-- header -->
        <div class="card-header bg-theme-blue">
            <h5><i class="fa fa-credit-card"></i> Payment</h5>
        </div>

        <div class="card-body">
        
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(!isset($activeRental) || !$activeRental)
                <div class="alert alert-warning">Bạn không có chuyến xe nào đang hoạt động. <a href="/rental">Thuê xe ngay!</a></div>
            @else
            <form action="{{ route('payment.return') }}" method="POST">
                @csrf
            <div class="row">
                
                <!-- left column -->
                <div class="col-md-6">
                   
                    <!-- bike information -->
                    <div class="info-box mb-4">
                        <h5><i class="fa fa-bicycle"></i> Thông tin xe đang thuê</h5>
                        <hr>
                        
                        <p><strong>Loại xe:</strong> {{ $activeRental->bike_type }}</p>
                        <p><strong>Trạm lấy:</strong> {{ $activeRental->station_start }}</p>
                        <p><strong>Thời gian bắt đầu:</strong> {{ $activeRental->start_time->format('H:i d/m/Y') }}</p>
                        <p><strong>Thời gian hiện tại:</strong> {{ \Carbon\Carbon::now()->format('H:i d/m/Y') }}</p>
                        <p><strong>Đơn giá:</strong> 5.000đ + 200đ / phút</p>
                        <p><strong>Thời gian thuê quy đổi tính đến hiện tại:</strong> 
                            {{ $activeRental->start_time->diffInMinutes(\Carbon\Carbon::now()) }} phút</p>
                        
                        <h5 class="text-danger">
                            Tạm tính: <span id="total">{{ number_format(5000 + ($activeRental->start_time->diffInMinutes(\Carbon\Carbon::now()) * 200)) }}</span> đồng
                        </h5>

                    </div>

                    <!-- return form -->
                    <div>
                        <h5><i class="fa fa-undo"></i> Trả xe</h5>                        
                        <!-- select ward -->
                        <div class="mb-3">
                            <label class="form-label">Chọn phường</label>
                            <select name="ward_slc" id="areaSelect" class="form-select">
                                <option value="">-- Chọn phường --</option>                                
                                @foreach($wards as $ward)
                                    <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- select station -->
                        <div class="mb-3">
                            <label class="form-label">Chọn trạm trả xe</label>
                            <select name="return_station" id="stationSelect" class="form-select border-0 shadow-sm">
                                <option value="">-- Chọn trạm --</option>
                                @foreach(\App\Models\Station::all() as $st)
                                    <option value="{{ $st->id }}" data-area="{{ $st->ward_id }}">Trạm {{ $st->name }} ({{ $st->ward->name ?? 'Ho Chi Minh' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- button -->
                        <button class="btn btn-theme rounded-pill fw-bold shadow-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="fa fa-money-bill"></i> Trả xe & Thanh toán
                        </button>
                    </div>

                </div>

                <!-- right column -->
                <div class="col-md-6 text-center">
                    <img src="/assets/payment.jpg" class="guide-img">
                    
                </div>

            </div>

            <!-- review modal -->
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header bg-theme-blue text-white">
                    <h5 class="modal-title" id="reviewModalLabel"><i class="fa fa-star text-warning"></i> Đánh giá Trải nghiệm</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-start">
                      <p>Cảm ơn bạn đã sử dụng dịch vụ BikeGo. Vui lòng để lại đánh giá về chuyến đi vừa rồi nhé!</p>
                      
                      <div class="mb-3">
                          <label class="form-label fw-bold">Đánh giá chung (Xe & Trạm)</label>
                          <select name="rating" class="form-select border-0 shadow-sm">
                              <option value="5" selected>⭐⭐⭐⭐⭐ - Rất tuyệt vời</option>
                              <option value="4">⭐⭐⭐⭐ - Hài lòng</option>
                              <option value="3">⭐⭐⭐ - Bình thường</option>
                              <option value="2">⭐⭐ - Kém</option>
                              <option value="1">⭐ - Rất kém</option>
                          </select>
                      </div>
                      
                      <div class="mb-3">
                          <label class="form-label fw-bold">Nhận xét thêm (Không bắt buộc)</label>
                          <textarea name="comment" class="form-control border-0 shadow-sm" rows="3" placeholder="Chia sẻ trải nghiệm của bạn về chất lượng xe, trạm bãi..."></textarea>
                      </div>
                  </div>
                  <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-theme rounded-pill fw-bold">Xác nhận Thanh toán</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- end modal -->

            </form>
            @endif
        
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // link area to stations 
    document.getElementById('areaSelect').addEventListener('change', function() {
        let area = this.value;
        let stationSelect = document.getElementById('stationSelect');
        let options = stationSelect.querySelectorAll('option');
        options.forEach(opt => {
            if(opt.value === "") return;
            if(area === "" || opt.getAttribute('data-area') === area) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
        stationSelect.value = "";
    });
</script>
@endpush

