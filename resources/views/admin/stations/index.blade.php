@extends('admin.layout')

@section('page-title', 'Quản lý trạm xe')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách trạm xe</h5>
                <a href="{{ route('admin.stations.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Thêm trạm
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Mã trạm</th>
                                <th>Tên trạm</th>
                                <th>Phường / Xã</th>
                                <th>Số lượng xe</th>
                                <th class="text-end pe-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stations as $station)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $station->code }}</td>
                                <td>{{ $station->name }}</td>
                                <td>{{ $station->ward->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info text-white">
                                        {{ \App\Models\Bike::where('current_station', $station->id)->count() }} xe
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.stations.edit', $station->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.stations.destroy', $station->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa trạm này?')">
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
                                <td colspan="5" class="text-center py-4 text-muted">Chưa có dữ liệu trạm nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
