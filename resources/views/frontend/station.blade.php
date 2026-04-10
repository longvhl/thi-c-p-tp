@extends('layouts.client')
@section('title', 'Vũ Hoàng Long PTW.B23')
@section('content')
<div class="container mt-4" style="min-height: 60vh;">

    <div class="card shadow-sm" >
        
        <!-- header -->
        <div class="card-header bg-theme-blue">
            <h5><i class="fa fa-map-marker-alt"></i> Stations</h5>
        </div>

        <div class="card-body">

            <!-- row 1: filter -->
            <div class="row mb-3">
                <div class="col-md-4 ms-auto">
                    <select id="areaFilter" class="form-select">
                        <option value="all">-- Chọn phường --</option>                  
                        @foreach($wards as $ward)
                            <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- row 2: list stations -->
            <div id="stationList">
                
                @foreach(\App\Models\Station::all() as $st)
                <!-- station {{ $st->id }} -->
                <div class="station-item" data-area="{{ $st->ward_id }}" data-bs-toggle="collapse" data-bs-target="#s{{ $st->id }}">
                    <i class="fa fa-bicycle text-theme-pink"></i> Trạm {{ $st->name }}
                </div>
                <div id="s{{ $st->id }}" class="collapse">
                    <div class="p-3 bg-light">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ $st->image_url ?: '/assets/default_station.png' }}" class="station-img rounded w-100" style="object-fit:cover; height: 180px;">
                            </div>
                            <div class="col-md-7">
                                <h5>{{ $st->name }} Station</h5>
                                <p>📍 Địa chỉ: {{ $st->ward->name ?? 'Ho Chi Minh' }}, TP.HCM</p>
                                <p>🚴 Xe còn: {{ \App\Models\Bike::where('current_station', $st->id)->where('status', 'available')->count() }}</p>
                                <p class="mb-1">Đánh giá nhanh:</p>
                                <span class="star-rating" style="cursor:pointer;" data-station-id="{{ $st->id }}">
                                    <i class="fa fa-star text-secondary fs-5" data-val="1"></i>
                                    <i class="fa fa-star text-secondary fs-5" data-val="2"></i>
                                    <i class="fa fa-star text-secondary fs-5" data-val="3"></i>
                                    <i class="fa fa-star text-secondary fs-5" data-val="4"></i>
                                    <i class="fa fa-star text-secondary fs-5" data-val="5"></i>
                                </span>
                                <!-- rating stats display here -->
                                <div class="rating-stats text-muted mt-1 mb-3" style="font-size: 0.9em;">
                                    <span class="rating-avg" id="avg-{{ $st->id }}">0</span>/5 (<span class="rating-percent" id="pct-{{ $st->id }}">0</span>%) - <span class="rating-count" id="cnt-{{ $st->id }}">0</span> lượt đánh giá
                                </div>

                                <!-- review section -->
                                <div class="review-section mt-3 p-3 bg-white rounded border">
                                    <h6><i class="fa fa-comments"></i> Đánh giá & Bình luận</h6>
                                    
                                    @auth
                                    <div class="review-form mb-3">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control review-comment" placeholder="Viết bình luận..." id="comment-{{ $st->id }}">
                                            <button class="btn btn-theme-blue submit-review" data-station-id="{{ $st->id }}">Gửi</button>
                                        </div>
                                        <input type="hidden" class="selected-rating" id="rating-{{ $st->id }}" value="0">
                                    </div>
                                    @else
                                    <p class="text-muted small"><a href="/login">Đăng nhập</a> để để lại bình luận.</p>
                                    @endauth

                                    <div class="reviews-list" id="list-{{ $st->id }}" style="max-height: 300px; overflow-y: auto;">
                                        <!-- reviews will be loaded here -->
                                        <p class="text-center text-muted small mt-2">Đang tải bình luận...</p>
                                    </div>
                                    <div class="text-center mt-2">
                                        <button class="btn btn-sm btn-outline-secondary load-more" data-station-id="{{ $st->id }}" data-offset="0" id="more-{{ $st->id }}" style="display:none;">Tải thêm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="/assets/js/filter_area_bikego.js"></script>
<script>
// csrf token for ajax
const csrfToken = '{{ csrf_token() }}';

// function to load reviews
function loadReviews(stationId, offset = 0, append = false) {
    fetch(`/review/more?station_id=${stationId}&offset=${offset}`)
        .then(res => res.json())
        .then(data => {
            const list = document.getElementById(`list-${stationId}`);
            const moreBtn = document.getElementById(`more-${stationId}`);
            
            if (offset === 0) list.innerHTML = '';
            
            if (data.reviews.length === 0 && offset === 0) {
                list.innerHTML = '<p class="text-center text-muted small mt-2">Chưa có bình luận nào.</p>';
            } else {
                data.reviews.forEach(r => {
                    const date = new Date(r.created_at).toLocaleDateString('vi-VN');
                    list.innerHTML += `
                        <div class="review-item border-bottom py-2">
                            <div class="d-flex justify-content-between">
                                <small class="fw-bold text-primary">${r.user.name}</small>
                                <small class="text-muted">${date}</small>
                            </div>
                            <div class="text-warning mb-1" style="font-size: 0.8em;">
                                ${'<i class="fas fa-star"></i>'.repeat(r.rating)}${'<i class="far fa-star"></i>'.repeat(5-r.rating)}
                            </div>
                            <p class="mb-0 small">${r.comment || ''}</p>
                        </div>
                    `;
                });
            }
            
            if (data.hasMore) {
                moreBtn.style.display = 'inline-block';
                moreBtn.dataset.offset = parseInt(offset) + 5;
            } else {
                moreBtn.style.display = 'none';
            }

            // update stats
            if (data.stats) {
                document.getElementById(`avg-${stationId}`).innerText = data.stats.avg;
                document.getElementById(`pct-${stationId}`).innerText = data.stats.percent;
                document.getElementById(`cnt-${stationId}`).innerText = data.stats.count;
            }
        });
}

document.addEventListener('shown.bs.collapse', function (e) {
    const rawId = e.target.id;
    if (rawId.startsWith('s')) {
        const stationId = rawId.substring(1);
        loadReviews(stationId);
    }
});

// handle star rating click
document.querySelectorAll('.star-rating i').forEach(star => {
    star.addEventListener('click', function() {
        const container = this.parentElement;
        const stationId = container.closest('.collapse').id.substring(1);
        const val = parseInt(this.getAttribute('data-val'));
        
        document.getElementById(`rating-${stationId}`).value = val;
        
        container.querySelectorAll('i').forEach(s => {
            if(parseInt(s.getAttribute('data-val')) <= val) {
                s.classList.remove('text-secondary', 'far');
                s.classList.add('text-warning', 'fas');
            } else {
                s.classList.remove('text-warning', 'fas');
                s.classList.add('text-secondary', 'far');
            }
        });
    });
});

// handle review submit
document.querySelectorAll('.submit-review').forEach(btn => {
    btn.addEventListener('click', function() {
        const stationId = this.dataset.stationId;
        const rating = document.getElementById(`rating-${stationId}`).value;
        const comment = document.getElementById(`comment-${stationId}`).value;
        
        if (rating == 0) {
            alert('Vui lòng chọn số sao đánh giá!');
            return;
        }
        
        fetch('/review/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ station_id: stationId, rating, comment })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`comment-${stationId}`).value = '';
                loadReviews(stationId, 0); // reload latest
            }
        });
    });
});

// handle load more
document.querySelectorAll('.load-more').forEach(btn => {
    btn.addEventListener('click', function() {
        loadReviews(this.dataset.stationId, this.dataset.offset, true);
    });
});
</script>
@endpush

