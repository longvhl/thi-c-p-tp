document.addEventListener('DOMContentLoaded', function() {
    const areaFilter = document.getElementById('areaFilter');
    if(areaFilter) {
        areaFilter.addEventListener('change', function() {
            const selected = this.value;
            const stations = document.querySelectorAll('.station-item');
            
            stations.forEach(station => {
                const area = station.getAttribute('data-area');
                const targetId = station.getAttribute('data-bs-target');
                const detailDiv = document.querySelector(targetId);
                
                if(selected === 'all' || area === selected) {
                    station.style.display = ''; // reset display to default
                } else {
                    station.style.display = 'none';
                    if(detailDiv) {
                        // collapse it if hidden
                        detailDiv.classList.remove('show');
                        detailDiv.style.display = 'none';
                    }
                }
            });
        });

        // whenever a station is clicked to toggle its collapse panel, reset the inline display none if any
        document.querySelectorAll('.station-item').forEach(st => {
            st.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');
                const detailDiv = document.querySelector(targetId);
                if (detailDiv) {
                    detailDiv.style.display = ''; // allow bootstrap transition
                }
            });
        });
    }
});
