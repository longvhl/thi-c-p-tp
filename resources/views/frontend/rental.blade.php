@extends('layouts.client')
@section('title', 'Vũ Hoàng Long PTW.B23')
@section('content')
<div class="container mt-4">
    
    <div class="card shadow-sm">

        <!-- header -->
        <div class="card-header bg-theme-blue">
            <h5><i class="fa fa-bicycle"></i> Rental Bike</h5>
        </div>

        <div class="card-body">
        
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('rental.store') }}" method="POST">
                @csrf
            <div class="row">
                
                <!-- left column: form -->
                <div class="col-md-6">
                    <!-- select ward -->
                    <div class="mb-3">
                        <label class="form-label">Chọn phường</label>
                        <select name="area_slc" id="areaSelect" class="form-select">
                            <option value="">-- Chọn phường --</option>                            
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- select station -->
                    <div class="mb-3">
                        <label class="form-label">Chọn trạm</label>
                        <select name="station_slc" id="stationSelect" class="form-select border-0 shadow-sm">
                            <option value="">-- Chọn trạm --</option>
                            @foreach($stations as $st)
                                <option value="{{ $st->id }}" data-area="{{ $st->ward_id }}">Trạm {{ $st->name }} ({{ $st->ward->name ?? 'Ho Chi Minh' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- select bike -->
                    <div class="mb-3">                        
                        <label class="form-label">Chọn xe và Biển số</label>
                        <div id="bikeList" class="p-3 bg-light rounded border mb-2" style="display:none; max-height: 300px; overflow-y: auto;">
                            <!-- bikes will be loaded here -->
                        </div>
                        <select name="bike_number" id="bikeNumberSelect" class="form-select border-0 shadow-sm" style="display:none;">
                            <option value="">-- Chọn Biển số xe --</option>
                        </select>
                        <div id="noBikesMsg" class="text-danger small" style="display:none;">Trạm này hiện không có xe nào sẵn sàng.</div>
                    </div>

                    <!-- button -->
                    <button class="btn btn-theme rounded-pill fw-bold shadow-sm w-100" type="submit" id="rentBtn" disabled>
                        <i class="fa fa-check-circle"></i> Rent Bike
                    </button>

                </div>
                
                <!-- right column: instructions -->
                <div class="col-md-6 text-center">
                    <img src="/assets/rental.jpg" class="guide-img">
                </div>

            </div>
            </form>
        
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // link area to stations
    document.getElementById('areaSelect').addEventListener('change', function() {
        let area = this.value;
        let stationSelect = document.getElementById('stationSelect');
        let options = stationSelect.querySelectorAll('option');
        options.forEach(opt => {
            if(opt.value === "") return;
            if(area === "" || opt.getAttribute('data-area') === area) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
        stationSelect.value = "";
        document.getElementById('bikeNumberSelect').style.display = 'none';
        document.getElementById('rentBtn').disabled = true;
    });

    // link station to bikes
    document.getElementById('stationSelect').addEventListener('change', function() {
        let stationId = this.value;
        let bikeSelect = document.getElementById('bikeNumberSelect');
        let bikeList = document.getElementById('bikeList');
        let noMsg = document.getElementById('noBikesMsg');
        let rentBtn = document.getElementById('rentBtn');

        if (!stationId) {
            bikeSelect.style.display = 'none';
            bikeList.style.display = 'none';
            rentBtn.disabled = true;
            return;
        }

        fetch(`/api/stations/${stationId}/bikes`)
            .then(res => res.json())
            .then(data => {
                bikeSelect.innerHTML = '<option value="">-- Chọn Biển số xe --</option>';
                bikeList.innerHTML = '';
                
                if (data.length > 0) {
                    bikeSelect.style.display = 'block';
                    bikeList.style.display = 'block';
                    noMsg.style.display = 'none';
                    
                    data.forEach(bike => {
                        let typeLabel = bike.type === 'xe_dien' ? 'Xe điện' : (bike.type === 'xe_thuong' ? 'Xe cơ' : 'Xe trợ lực');
                        let option = document.createElement('option');
                        option.value = bike.bike_number;
                        option.textContent = `${bike.bike_number} (${typeLabel})`;
                        bikeSelect.appendChild(option);

                        // visual indicator
                        let item = document.createElement('div');
                        item.className = 'd-flex justify-content-between align-items-center p-2 mb-1 bg-white rounded shadow-sm border-start border-4 border-primary';
                        item.innerHTML = `
                            <span><i class="fa fa-bicycle text-theme-pink"></i> <b>${bike.bike_number}</b></span>
                            <span class="badge bg-theme-blue">${typeLabel}</span>
                        `;
                        bikeList.appendChild(item);
                    });
                } else {
                    bikeSelect.style.display = 'none';
                    bikeList.style.display = 'none';
                    noMsg.style.display = 'block';
                    rentBtn.disabled = true;
                }
            });
    });

    document.getElementById('bikeNumberSelect').addEventListener('change', function() {
        document.getElementById('rentBtn').disabled = !this.value;
    });
</script>
@endpush

