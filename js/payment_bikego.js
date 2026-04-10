// ===== DATA GIẢ =====
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

// ===== TÍNH TIỀN =====
const pricePerMinute = 5000;

// giả lập thời gian bắt đầu (10 phút trước)
const start = new Date(new Date().getTime() - 10 * 60000);
document.getElementById("startTime").innerText = start.toLocaleString();

function updateTime() {
    let now = new Date();
    let diff = Math.floor((now - start) / 60000); // phút

    document.getElementById("duration").innerText = diff;
    document.getElementById("total").innerText = (diff * pricePerMinute).toLocaleString();
}

setInterval(updateTime, 1000);