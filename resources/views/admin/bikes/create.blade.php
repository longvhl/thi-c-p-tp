@extends('admin.layout')

@section('page-title', 'Thêm xe mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin xe</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.bikes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Biển số xe</label>
                        <input type="text" name="bike_number" class="form-control" placeholder="Ví dụ: BIKE-001" required value="{{ old('bike_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại xe</label>
                        <select name="type" class="form-select" required>
                            <option value="xe_thuong" {{ old('type') == 'xe_thuong' ? 'selected' : '' }}>Xe thường</option>
                            <option value="xe_dien" {{ old('type') == 'xe_dien' ? 'selected' : '' }}>Xe điện</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạm xe (Vị trí hiện tại)</label>
                        <select name="current_station" class="form-select" required>
                            <option value="">-- Chọn trạm --</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{ old('current_station') == $station->id ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tình trạng</label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Bình thường</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Đang sửa</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.bikes.index') }}" class="btn btn-light me-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
