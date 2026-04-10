@extends('admin.layout')

@section('page-title', 'Chỉnh sửa xe: ' . $bike->bike_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật thông tin xe</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.bikes.update', $bike->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Biển số xe</label>
                        <input type="text" name="bike_number" class="form-control" value="{{ old('bike_number', $bike->bike_number) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại xe</label>
                        <select name="type" class="form-select" required>
                            <option value="xe_thuong" {{ old('type', $bike->type) == 'xe_thuong' ? 'selected' : '' }}>Xe thường</option>
                            <option value="xe_dien" {{ old('type', $bike->type) == 'xe_dien' ? 'selected' : '' }}>Xe điện</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạm xe (Vị trí hiện tại)</label>
                        <select name="current_station" class="form-select" required>
                            <option value="">-- Chọn trạm --</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{ old('current_station', $bike->current_station) == $station->id ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tình trạng</label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ old('status', $bike->status) == 'available' ? 'selected' : '' }}>Bình thường</option>
                            <option value="maintenance" {{ old('status', $bike->status) == 'maintenance' ? 'selected' : '' }}>Đang sửa</option>
                            <option value="rented" {{ old('status', $bike->status) == 'rented' ? 'selected' : '' }}>Đang thuê</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.bikes.index') }}" class="btn btn-light me-2">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
