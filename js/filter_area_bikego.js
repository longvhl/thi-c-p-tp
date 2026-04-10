// FILTER THEO KHU VỰC
document.getElementById("areaFilter").addEventListener("change", function () {
    let value = this.value;
    let stations = document.querySelectorAll(".station-item");

    stations.forEach(station => {
        let area = station.getAttribute("data-area");

        if (value === "all" || value === area) {
            station.style.display = "block";
        } else {
            station.style.display = "none";
        }

        // đóng collapse khi filter
        let target = document.querySelector(station.dataset.bsTarget);
        if (target) {
            target.classList.remove("show");
        }
    });
});