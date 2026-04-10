@extends('admin.layout')

@section('page-title', 'Thêm trạm xe mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin trạm xe</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.stations.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên trạm</label>
                        <input type="text" name="name" class="form-control" placeholder="Ví dụ: Bến Thành" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mã trạm (Code)</label>
                        <input type="text" name="code" class="form-control" placeholder="Ví dụ: BT01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn phường</label>
                        <select name="ward_id" class="form-select" required>
                            <option value="">-- Chọn phường --</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Link ảnh trạm (URL)</label>
                        <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg">
                        <small class="text-muted">Để trống để dùng ảnh mặc định.</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu trạm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
