// DATA GIẢ
const stations = {
    q1: ["Bến Thành", "Nguyễn Huệ"],
    q3: ["Võ Văn Tần", "Cách Mạng Tháng 8"],
    q7: ["Phú Mỹ Hưng", "Nguyễn Lương Bằng"]
};

const areaSelect = document.getElementById("areaSelect");
const stationSelect = document.getElementById("stationSelect");

// Load trạm theo khu vực
areaSelect.addEventListener("change", function () {
    let area = this.value;

    stationSelect.innerHTML = '<option value="">-- Chọn trạm --</option>';

    if (stations[area]) {
        stations[area].forEach(station => {
            let option = document.createElement("option");
            option.value = station;
            option.textContent = station;
            stationSelect.appendChild(option);
        });
    }
});