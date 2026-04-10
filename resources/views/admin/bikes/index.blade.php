@extends('admin.layout')

@section('page-title', 'Quản lý xe')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách xe</h5>
                <div>
                    <button type="submit" form="bulk-delete-form" class="btn btn-warning me-2" onclick="return confirm('Bạn có chắc muốn xóa các xe đã chọn?')">
                        <i class="fa fa-trash-alt me-1"></i> Xóa xe đã chọn
                    </button>
                    <a href="{{ route('admin.bikes.create') }}" class="btn btn-primary me-2">
                        <i class="fa fa-plus me-1"></i> Thêm xe
                    </a>
                    <a href="{{ route('admin.bikes.bin') }}" class="btn btn-secondary">
                        <i class="fa fa-trash me-1"></i> Thùng rác
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <form id="bulk-delete-form" action="{{ route('admin.bikes.bulkDestroy') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 40px;">
                                    <input class="form-check-input" type="checkbox" id="check-all">
                                </th>
                                <th>Biển số</th>
                                <th>Vị trí hiện tại</th>
                                <th>Tình trạng</th>
                                <th>Điểm đánh giá</th>
                                <th class="text-end pe-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bikes as $bike)
                            <tr>
                                <td class="ps-4">
                                    <input class="form-check-input bike-checkbox" type="checkbox" name="bike_ids[]" value="{{ $bike->id }}">
                                </td>
                                <td>
                                    <a href="{{ route('admin.bikes.show', $bike->id) }}" class="fw-bold text-decoration-none">
                                        {{ $bike->bike_number }}
                                    </a>
                                </td>
                                <td>
                                    @if($bike->status == 'rented')
                                        <span class="text-warning"><i class="fa fa-user-clock me-1"></i> Đang thuê</span>
                                    @else
                                        <span class="text-muted">
                                            <i class="fa fa-map-marker-alt me-1"></i> {{ $bike->station->name ?? 'Không xác định' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($bike->status == 'available')
                                        <span class="badge badge-available">Bình thường</span>
                                    @elseif($bike->status == 'maintenance')
                                        <span class="badge badge-maintenance">Đang sửa</span>
                                    @else
                                        <span class="badge badge-rented">Đang thuê</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-warning">
                                        @php $avgRating = $bike->reviews()->avg('rating') ?: 0; @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= round($avgRating) ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                        <span class="text-muted ms-1">({{ number_format($avgRating, 1) }})</span>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.bikes.edit', $bike->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.bikes.destroy', $bike->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa mềm xe này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa có dữ liệu xe nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
            @if($bikes->hasPages())
            <div class="card-footer bg-white">
                {{ $bikes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('check-all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.bike-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>
@endpush
