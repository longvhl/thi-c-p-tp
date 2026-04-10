@extends('layouts.client')
@section('title', 'Vũ Hoàng Long PTW.B23')
@section('content')
<style>
    .top-biker-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .top-biker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        background-color: #f8f9fa;
    }
    .list-group-item-hover:hover {
        background-color: #e9ecef;
        transform: scale(1.02);
        transition: all 0.2s ease;
        cursor: pointer;
    }
</style>
<!-- top biker -->
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-theme-blue">
            <h5 class="mb-0 flicker-text"><i class="fa fa-trophy me-2"></i>Top Biker</h5>
        </div>

        <div class="card-body">

            <!-- top 1-3 -->
            <div class="row mb-3">
                @if(isset($topBikers) && count($topBikers) > 0)
                @foreach($topBikers->take(3) as $idx => $tb)
                <div class="col-md-4">
                    <div class="top-user text-center p-3 border rounded top-biker-card shadow-sm h-100">
                        <div class="fs-1">
                        @if($idx == 0) 🥇
                        @elseif($idx == 1) 🥈
                        @else 🥉
                        @endif
                        </div>
                        <h5 class="fw-bold mb-1">{{ $tb->name ?? ($tb->user->name ?? 'Người dùng') }}</h5>
                        <p class="text-muted small mb-2">Số điện thoại: ****{{ $tb->phone_last_3 ?? substr($tb->user->phone ?? '000', -3) }}</p>
                        <div class="badge bg-theme-blue mb-1">{{ $tb->total_trips }} lần thuê</div>
                        <div class="text-theme-pink small">⏱ {{ $tb->total_duration }} phút</div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12 text-center text-muted">Chưa có dữ liệu từ Database</div>
                @endif
            </div>

            <!-- remaining top (4-10) -->
            <div class="row">
                <div class="col-12">                    
                    <div  class="card shadow-sm">
                        <div class="card-header">
                            <h5>List Bikers</h5>
                        </div>
                        <div class="card-body p-0">
                            @if(isset($topBikers) && count($topBikers) > 3)
                            <ul class="list-group list-group-flush">
                                @foreach($topBikers->slice(3) as $idx => $tb)
                                <li class="list-group-item list-group-item-hover d-flex justify-content-between align-items-center py-3">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold me-3 text-secondary">#{{ $idx + 4 }}</span>
                                        <div>
                                            <div class="fw-bold">{{ $tb->name ?? ($tb->user->name ?? 'Người dùng') }}</div>
                                            <div class="text-muted small">ĐT: ****{{ $tb->phone_last_3 ?? substr($tb->user->phone ?? '000', -3) }}</div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-theme-blue rounded-pill">{{ $tb->total_trips }} lần</span>
                                        <div class="text-theme-pink extra-small" style="font-size: 0.75em;">⏱ {{ $tb->total_duration }} phút</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-center text-muted p-3">Chưa có thêm dữ liệu xếp hạng</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- let's bikego -->
<div class="container mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header bg-theme-blue text-white py-3">
            <h5 class="mb-0 flicker-text"><i class="fa fa-bicycle me-2"></i>Let's BikeGo</h5>
        </div>

        <div class="card-body bg-light">
            <div class="row text-center g-4">
                <div class="col-md-6">
                    <div class="stat-box h-100 p-4 border-0 shadow-sm" style="background: white; border-radius: 15px;">
                        <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                            <i class="fa fa-bicycle text-primary" style="font-size: 30px;"></i>
                        </div>
                        <h3 class="fw-bold text-primary">{{ $totalBikes }}</h3>
                        <p class="text-muted mb-0">Tổng số lượng xe hiện có</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="stat-box h-100 p-4 border-0 shadow-sm" style="background: white; border-radius: 15px;">
                        <div class="bg-info bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                            <i class="fa fa-map-marked-alt text-info" style="font-size: 30px;"></i>
                        </div>
                        <h3 class="fw-bold text-info">{{ $totalStationsCount }}</h3>
                        <p class="text-muted mb-0">Tổng số lượng trạm xe hiện có</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- top stations -->
<div class="container mt-4 mb-5">
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 flicker-text"><i class="fa fa-star me-2"></i>Top Stations</h5>
            <span class="badge bg-dark rounded-pill">10 Trạm tốt nhất</span>
        </div>

        <div class="card-body">
            <div class="position-relative px-5">
                <button class="nav-btn nav-left bg-dark bg-opacity-50 border-0 rounded-circle" style="width: 40px; height: 40px;" onclick="moveSlide(-1)">❮</button>
                <button class="nav-btn nav-right bg-dark bg-opacity-50 border-0 rounded-circle" style="width: 40px; height: 40px;" onclick="moveSlide(1)">❯</button>

                <div class="banner" style="height: auto; overflow: hidden;">
                    <div class="slider d-flex" id="slider" style="transition: transform 0.5s ease;">
                        @foreach($topStations as $station)
                        <div class="slide flex-shrink-0" style="width: 25%; padding: 10px;">
                            <div class="card h-100 border-0 shadow-sm station-card" style="border-radius: 15px; overflow: hidden;">
                                <img src="{{ $station->image_url ?: '/assets/default_station.png' }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-truncate mb-1">{{ $station->name }}</h6>
                                    <div class="text-warning small mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= round($station->avg_rating) ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                        <span class="text-muted">({{ number_format($station->avg_rating, 1) }})</span>
                                    </div>
                                    <div class="comments-section small text-muted">
                                        @forelse($station->recent_comments as $comment)
                                            <div class="text-truncate" style="font-size: 0.75rem;">
                                                <i class="fa fa-comment-dots me-1"></i> {{ $comment->comment }}
                                            </div>
                                        @empty
                                            <div class="font-italic" style="font-size: 0.75rem;">Chưa có nhận xét nào</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="/assets/js/master_bikego.js"></script>
@endpush

