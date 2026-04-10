@extends('admin.layout')

@section('page-title', 'Chi tiết xe: ' . $bike->bike_number)

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin xe</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-4 d-inline-block rounded-circle mb-3">
                        <i class="fa fa-bicycle text-primary" style="font-size: 60px;"></i>
                    </div>
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold text-muted fw-bold" style="width: 140px;">Biển số:</td>
                        <td class="fw-bold">{{ $bike->bike_number }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted fw-bold">Loại xe:</td>
                        <td>{{ $bike->type == 'xe_thuong' ? 'Xe thường' : 'Xe điện' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted fw-bold">Trạm:</td>
                        <td>{{ $bike->station->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted fw-bold">Tình trạng:</td>
                        <td>
                            @if($bike->status == 'available')
                                <span class="badge badge-available">Bình thường</span>
                            @elseif($bike->status == 'maintenance')
                                <span class="badge badge-maintenance">Đang sửa</span>
                            @else
                                <span class="badge badge-rented">Đang thuê</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('admin.bikes.edit', $bike->id) }}" class="btn btn-primary">
                        <i class="fa fa-edit me-1"></i> Chỉnh sửa thông tin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Đánh giá từ người dùng</h5>
            </div>
            <div class="card-body p-0">
                @forelse($bike->reviews as $review)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold text-primary">{{ $review->user->name ?? 'Người dùng' }}</div>
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="mb-1 text-secondary small">{{ $review->comment ?: 'Không có bình luận.' }}</p>
                    <div class="text-muted extra-small" style="font-size: 0.75rem;">
                        {{ $review->created_at->diffForHumans() }}
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">
                    Chưa có đánh giá nào cho xe này.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
