// ===============================
// FUNGSI FORMAT RUPIAH
// ===============================
function formatRupiah(angka, prefix) {
    if (typeof angka === "number") angka = angka.toString();
    if (!angka) return "";

    const numberString = angka.replace(/[^,\d]/g, "").toString();
    const split = numberString.split(",");
    const sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        const separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
    return prefix ? prefix + rupiah : rupiah;
}

// ===============================
// TERAPKAN FORMAT RUPIAH
// ===============================
function applyRupiahFormat() {
    document.querySelectorAll(".rupiah").forEach((input) => {
        // Hapus dua nol terakhir hanya untuk nilai awal (saat edit)
        function removeLastTwoZeros(value) {
            value = value.replace(/[^0-9]/g, "");
            return value.replace(/00$/, ""); // hanya kalau benar-benar di akhir
        }

        // Saat halaman edit (nilai sudah ada)
        if (input.value) {
            let rawValue = removeLastTwoZeros(input.value);
            input.value = formatRupiah(rawValue, "Rp ");
        }

        // Saat mengetik — jangan hapus nol
        input.addEventListener("input", function () {
            let rawValue = this.value.replace(/[^0-9]/g, "");
            this.value = formatRupiah(rawValue, "Rp ");
        });
    });
}

// ===============================
// HAPUS FORMAT RUPIAH SEBELUM SUBMIT
// ===============================
document.addEventListener(
    "submit",
    function (e) {
        e.target.querySelectorAll(".rupiah").forEach((input) => {
            input.value = input.value.replace(/[^0-9]/g, ""); // kirim angka mentah ke server
        });
    },
    true
);

// ===============================
// HITUNG TOTAL OTOMATIS (PRICE × QTY)
// ===============================
function applyAutoTotal() {
    const priceInput = document.getElementById("price");
    const qtyInput = document.getElementById("number");
    const totalInput = document.getElementById("total");

    if (!priceInput || !qtyInput || !totalInput) return;

    function calculateTotal() {
        const price = parseInt(priceInput.value.replace(/[^0-9]/g, "")) || 0;
        const qty = parseInt(qtyInput.value.replace(/[^0-9]/g, "")) || 0;
        const total = price * qty;
        totalInput.value = formatRupiah(total.toString(), "Rp ");
    }

    priceInput.addEventListener("input", calculateTotal);
    qtyInput.addEventListener("input", calculateTotal);
}
function applyAutoTotalDua() {
    const priceoutInput = document.getElementById("priceout");
    const qtyoutInput = document.getElementById("number");
    const totaloutInput = document.getElementById("totalout");

    if (!priceoutInput || !qtyoutInput || !totaloutInput) return;

    function calculateTotal() {
        const priceout =
            parseInt(priceoutInput.value.replace(/[^0-9]/g, "")) || 0;
        const qtyout = parseInt(qtyoutInput.value.replace(/[^0-9]/g, "")) || 0;
        const totalout = priceout * qtyout;
        totaloutInput.value = formatRupiah(totalout.toString(), "Rp ");
    }

    priceoutInput.addEventListener("input", calculateTotal);
    qtyoutInput.addEventListener("input", calculateTotal);
}

// ===============================
// JALANKAN SEMUA SAAT HALAMAN DIMUAT
// ===============================
document.addEventListener("DOMContentLoaded", () => {
    applyRupiahFormat();
    applyAutoTotal();
    applyAutoTotalDua();
    onlyNumberInput();
});

// ===============================
// DUKUNGAN UNTUK LIVEWIRE / FILAMENT
// ===============================
document.addEventListener("livewire:load", () => {
    applyRupiahFormat();
    applyAutoTotal();
    onlyNumberInput();
});

document.addEventListener("livewire:update", () => {
    applyRupiahFormat();
    applyAutoTotal();
    onlyNumberInput();
});
