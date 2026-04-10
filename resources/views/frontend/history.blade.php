@extends('layouts.client')

@section('title', 'Lịch sử thuê xe')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header bg-theme-blue text-white py-3">
            <h5 class="mb-0"><i class="fa fa-history me-2"></i> Lịch sử thuê xe</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Biển số xe</th>
                            <th>Trạm lấy xe</th>
                            <th>Trạm trả xe</th>
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian trả xe</th>
                            <th>Số phút</th>
                            <th class="text-end pe-4">Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $rental->bike_number }}</td>
                            <td>{{ $rental->station_start }}</td>
                            <td>{{ $rental->station_end }}</td>
                            <td>{{ $rental->start_time->format('d/m/Y H:i') }}</td>
                            <td>{{ $rental->end_time ? $rental->end_time->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                @if($rental->end_time)
                                    {{ $rental->start_time->diffInMinutes($rental->end_time) }} phút
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end pe-4 fw-bold text-theme-pink">
                                {{ number_format($rental->total_cost, 0, ',', '.') }} VNĐ
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa fa-bicycle fs-1 mb-3 d-block"></i>
                                Bạn chưa có lịch sử thuê xe nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
