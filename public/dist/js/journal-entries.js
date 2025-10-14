document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("journalContainer");
    const addBtn = document.getElementById("addEntries");

    function formatRupiah(angka, prefix = "Rp. ") {
        if (typeof angka === "number") angka = angka.toString();
        angka = angka.replace(/[^,\d]/g, ""); // hapus semua kecuali angka dan koma
        const split = angka.split(",");
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? prefix + rupiah : "";
    }

    // Fungsi hapus format rupiah jadi angka murni
    function unformatRupiah(str) {
        return parseInt(str.replace(/[^0-9]/g, "")) || 0;
    }

    // Fungsi hitung total (harga × qty) + format harga real-time
    function attachTotalCalculation(entry) {
        const priceInput = entry.querySelector('input[name="price[]"]');
        const qtyInput = entry.querySelector('input[name="qty[]"]');
        const totalInput = entry.querySelector('input[name="total[]"]');

        // Format harga saat diketik
        priceInput.addEventListener("input", function () {
            const angka = unformatRupiah(priceInput.value);
            priceInput.value = formatRupiah(angka.toString());
            calculateTotal();
        });

        qtyInput.addEventListener("input", calculateTotal);

        function calculateTotal() {
            const harga = unformatRupiah(priceInput.value);
            const qty = parseInt(qtyInput.value) || 0;
            const total = harga * qty;
            totalInput.value = formatRupiah(total.toString());
        }
    }

    // Fungsi update header dan tombol hapus
    function updateEntries() {
        const entries = container.querySelectorAll(".journal-entry");
        entries.forEach((entry, index) => {
            const header = entry.querySelector(".card-header h3");
            header.textContent = `Detail Journal`;

            // Tambah tombol hapus
            let removeBtn = entry.querySelector(".remove-entry");
            if (index >= 2) {
                if (!removeBtn) {
                    removeBtn = document.createElement("button");
                    removeBtn.type = "button";
                    removeBtn.className =
                        "btn btn-danger btn-sm remove-entry float-right";
                    removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    entry.querySelector(".card-header").appendChild(removeBtn);

                    removeBtn.addEventListener("click", () => {
                        if (container.children.length > 2) {
                            entry.remove();
                            updateEntries();
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: "Minimal 2 Detail Journal",
                                text: "Tidak bisa menghapus, minimal harus ada 2 baris.",
                            });
                        }
                    });
                }
            } else if (removeBtn) {
                removeBtn.remove();
            }
            attachTotalCalculation(entry);
        });
    }

    // Tambah journal baru
    addBtn.addEventListener("click", function () {
        const first = container.querySelector(".journal-entry");
        const clone = first.cloneNode(true);

        // Reset nilai input
        clone.querySelectorAll("input").forEach((i) => {
            if (i.classList.contains("qty")) {
                i.value = 1;
            } else {
                i.value = "1";
            }
        });
        clone.querySelectorAll("select").forEach((s) => (s.selectedIndex = 0));

        container.appendChild(clone);
        updateEntries();
    });

    // Pastikan minimal 2 entry saat load pertama kali
    while (container.children.length < 2) {
        const clone = container.firstElementChild.cloneNode(true);
        clone.querySelectorAll("input").forEach((i) => {
            if (i.classList.contains("qty")) i.value = 1;
            else i.value = "";
        });
        clone.querySelectorAll("select").forEach((s) => (s.selectedIndex = 0));
        container.appendChild(clone);
    }

    updateEntries();
});
