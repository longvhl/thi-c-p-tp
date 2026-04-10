@extends('admin.layout')

@section('page-title', 'Chỉnh sửa trạm xe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật thông tin trạm</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.stations.update', $station->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên trạm</label>
                        <input type="text" name="name" class="form-control" value="{{ $station->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mã trạm (Code)</label>
                        <input type="text" name="code" class="form-control" value="{{ $station->code }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn phường</label>
                        <select name="ward_id" class="form-select" required>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}" {{ $station->ward_id == $ward->id ? 'selected' : '' }}>
                                    {{ $ward->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Link ảnh trạm (URL)</label>
                        <input type="url" name="image_url" class="form-control" value="{{ $station->image_url }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
