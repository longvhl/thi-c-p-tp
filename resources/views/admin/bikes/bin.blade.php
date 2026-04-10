@extends('admin.layout')

@section('page-title', 'Thùng rác - Xe đã xóa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách xe trong thùng rác</h5>
                <div class="d-flex align-items-center">
                    <button type="submit" form="bulk-restore-form" class="btn btn-success me-2" onclick="return confirm('Bạn có chắc muốn khôi phục các xe đã chọn?')">
                        <i class="fa fa-undo me-1"></i> Khôi phục xe đã chọn
                    </button>
                    <a href="{{ route('admin.bikes.index') }}" class="btn btn-light">
                        <i class="fa fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            <div class="card-body p-0">
                <form id="bulk-restore-form" action="{{ route('admin.bikes.bulkRestore') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 40px;">
                                    <input class="form-check-input" type="checkbox" id="check-all">
                                </th>
                                <th>Biển số</th>
                                <th>Tình trạng (Lúc xóa)</th>
                                <th class="text-end pe-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bikes as $bike)
                            <tr>
                                <td class="ps-4">
                                    <input class="form-check-input bike-checkbox" type="checkbox" name="bike_ids[]" value="{{ $bike->id }}">
                                </td>
                                <td class="fw-bold">{{ $bike->bike_number }}</td>
                                <td>
                                    @if($bike->status == 'available')
                                        <span class="badge badge-available">Bình thường</span>
                                    @elseif($bike->status == 'maintenance')
                                        <span class="badge badge-maintenance">Đang sửa</span>
                                    @else
                                        <span class="badge badge-rented">Đang thuê</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.bikes.restore', $bike->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success me-1">
                                            <i class="fa fa-undo"></i> Khôi phục
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Chức năng xóa vĩnh viễn chưa được yêu cầu cụ thể.')">
                                        <i class="fa fa-times text-danger"></i> Xóa vĩnh viễn
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Thùng rác trống.</td>
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
