</div>
</div>
</div>


<!--   Core JS Files   -->
<script src="../assets/js/core/jquery-3.7.1.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
<script src="../assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="../assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="../assets/js/plugin/jsvectormap/world.js"></script>

<!-- Sweet Alert -->
<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Kaiadmin JS -->
<script src="../assets/js/kaiadmin.min.js"></script>
<!-- Kaiadmin -->

<script>
    $(document).ready(function() {

        // settingan dataTable
        $('#basic-datatables').DataTable({});

        var table = $('#multi-filter-select').DataTable({


            "pageLength": 10,
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $('<select class="form-control"><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $('#addRowButton').click(function() {
            $('#add-row').dataTable().fnAddData([
                $("#addName").val(),
                $("#addPosition").val(),
                $("#addOffice").val(),
                action
            ]);
            $('#addRowModal').modal('hide');

        });

        // Filter Tanggal
        $('#start-date, #end-date').on('change', function () {
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();

            if (startDate && endDate) {
                // Tambahkan custom search untuk filter tanggal
                $.fn.dataTable.ext.search.push(function (settings, data) {
                    var date = new Date(data[1]); // Kolom tanggal (index 2)
                    return date >= new Date(startDate) && date <= new Date(endDate);
                });
            } else {
                // Hapus custom search jika tanggal kosong
                $.fn.dataTable.ext.search = [];
            }

            table.draw();
        });

        // Tombol Reset
        $('#reset-filter').on('click', function () {
            location.reload(); // Refresh halaman
        });
    });
</script>

<script>
    let totalAmount = 0;

    // Tambah menu ke daftar pesanan
    document.querySelectorAll('.addMenu').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseInt(this.getAttribute('data-price'));
            const quantity = parseInt(document.getElementById(`quantity${id}`).value);

            if (quantity > 0) {
                const subtotal = price * quantity;

                // Cek apakah item sudah ada
                const existingRow = document.querySelector(`#orderList tr[data-id="${id}"]`);
                if (existingRow) {
                    const qtyField = existingRow.querySelector('.orderQuantity');
                    const subtotalField = existingRow.querySelector('.orderSubtotal');
                    const currentQty = parseInt(qtyField.textContent);
                    const newQty = currentQty + quantity;
                    qtyField.textContent = newQty;
                    subtotalField.textContent = price * newQty;
                } else {
                    // Tambah item ke tabel pesanan
                    const row = `<tr data-id="${id}">
                        <td>${name}</td>
                        <td class="orderQuantity">${quantity}</td>
                        <td class="orderSubtotal">${subtotal}</td>
                        <td><button type="button" class="btn btn-danger removeMenu">Hapus</button></td>
                    </tr>`;
                    document.querySelector('#orderList tbody').insertAdjacentHTML('beforeend', row);
                }

                // Update total
                totalAmount += subtotal;
                document.getElementById('totalAmount').value = totalAmount;

                // Tambahkan event listener untuk tombol hapus
                document.querySelectorAll('.removeMenu').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const row = this.closest('tr');
                        const rowSubtotal = parseInt(row.querySelector('.orderSubtotal').textContent);
                        totalAmount -= rowSubtotal;
                        document.getElementById('totalAmount').value = totalAmount;
                        row.remove();
                    });
                });
            } else {
                alert("Jumlah harus lebih dari 0!");
            }
        });
    });
</script>

<!-- total -->
<script>
    // Ambil elemen yang diperlukan
    const discountDropdown = document.getElementById('discount_id');
    const discountInput = document.getElementById('discountAmount');
    const totalInput = document.getElementById('totalAmount'); // Total otomatis
    const finalTotalInput = document.getElementById('finalTotal');

    // Fungsi untuk menghitung total setelah diskon
    function calculateFinalTotal() {
        const totalAmount = parseFloat(totalInput.value) || 0; // Total otomatis
        const discountPercentage = parseFloat(discountInput.value) || 0; // Diskon dalam persen

        // Kalkulasi total setelah diskon
        const discountAmount = (totalAmount * discountPercentage) / 100;
        const finalTotal = totalAmount - discountAmount;

        // Perbarui kolom total setelah diskon
        finalTotalInput.value = finalTotal.toFixed(2);
    }

    // Event listener untuk dropdown diskon
    discountDropdown.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const discountPercentage = selectedOption.getAttribute('data-percentage') || 0;
        discountInput.value = discountPercentage;

        // Hitung total setelah diskon
        calculateFinalTotal();
    });

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-delete')) {
            // Hapus pesanan secara visual (opsional: tambahkan logika backend untuk hapus data)
            const rowToDelete = event.target.closest('tr'); // Misalkan dalam tabel
            rowToDelete.remove();

            // Cek jika tidak ada pesanan lagi, reset total
            const remainingRows = document.querySelectorAll('table tbody tr'); // Sesuaikan dengan struktur tabel
            if (remainingRows.length === 0) {
                resetTotals();
            } else {
                // Hitung ulang total jika masih ada pesanan
                // (Tambahkan logika untuk menghitung ulang total amount dari item yang tersisa)
                calculateFinalTotal();
            }
        }
         });


    function resetTotals() {
        totalInput.value = "0";
        finalTotalInput.value = "0";
        calculateFinalTotal();
    }

    // Jika total otomatis diubah oleh sistem, tambahkan observer atau polling untuk update
    setInterval(calculateFinalTotal, 500); // Periksa perubahan setiap 500ms (opsional jika total berubah dinamis)
</script>

<script>
    // Ambil elemen dropdown dan kolom diskon
    const discountDropdown = document.getElementById('discount_id');
    const discountInput = document.getElementById('discountAmount');

    // Tambahkan event listener untuk dropdown
    discountDropdown.addEventListener('change', function () {
        // Ambil nilai dari atribut data-percentage
        const selectedOption = this.options[this.selectedIndex];
        const discountPercentage = selectedOption.getAttribute('data-percentage') || 0;

        // Perbarui kolom diskon
        discountInput.value = discountPercentage;
    });
</script>

<!-- <script>
    // Ambil elemen-elemen yang diperlukan
    const totalInput = document.getElementById('totalAmount');
    const finalTotalInput = document.getElementById('finalTotal');
    const discountInput = document.getElementById('discountAmount');

    // Fungsi untuk menghitung ulang total setelah diskon
    function calculateFinalTotal() {
        const totalAmount = parseFloat(totalInput.value) || 0; // Total sebelum diskon
        const discountPercentage = parseFloat(discountInput.value) || 0; // Diskon dalam persen

        // Kalkulasi total setelah diskon
        const discountAmount = (totalAmount * discountPercentage) / 100;
        const finalTotal = totalAmount - discountAmount;

        // Perbarui kolom total setelah diskon
        finalTotalInput.value = finalTotal.toFixed(2);
    }

    // Fungsi untuk mengatur ulang total jika semua pesanan dihapus
    function resetTotals() {
        totalInput.value = "0";
        finalTotalInput.value = "0";
        calculateFinalTotal();
    }

    // Event listener untuk tombol hapus
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-delete')) {
            // Hapus pesanan secara visual (opsional: tambahkan logika backend untuk hapus data)
            const rowToDelete = event.target.closest('tr'); // Misalkan dalam tabel
            rowToDelete.remove();

            // Cek jika tidak ada pesanan lagi, reset total
            const remainingRows = document.querySelectorAll('table tbody tr'); // Sesuaikan dengan struktur tabel
            if (remainingRows.length === 0) {
                resetTotals();
            } else {
                // Hitung ulang total jika masih ada pesanan
                // (Tambahkan logika untuk menghitung ulang total amount dari item yang tersisa)
                calculateFinalTotal();
            }
        }
    });
</script>
 -->


</body>

</html>