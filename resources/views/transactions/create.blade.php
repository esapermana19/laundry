@extends('layouts.vuexy')
@section('page-title', 'Transaksi Baru')
@section('content')

    <div id="screen-pos" class="w-full max-w-full bg-white rounded-xl shadow-lg border border-slate-200 mb-6 mx-1">
        <div class="p-4 bg-sky-600 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-cash-register"></i>
                <span class="font-bold tracking-wide">WashFlow POS (Kasir)</span>
            </div>
            <span class="text-xs bg-sky-700 px-2.5 py-1 rounded-full text-sky-100 font-semibold" id="pos-invoice">
                {{-- NO: {{ $invoiceNumber }} --}}
            </span>
        </div>

        <form action="{{ route('transactions.store') }}" method="POST" id="pos-form">
            @csrf
            <input type="hidden" name="invoice_number" value="{{ $invoiceNumber }}">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4">
                <div class="md:col-span-7 flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">Pilih Pelanggan <span
                                class="text-rose-500">*</span></label>
                        <div class="flex gap-2">
                            <select id="pos-customer" name="customer_id" onchange="updateSummary()"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <option value="" disabled selected>-- Pilih Pelanggan --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" data-name="{{ $customer->customer_name }}"
                                        data-phone="{{ $customer->customer_phone }}">
                                        {{ $customer->customer_name }} ({{ $customer->customer_phone }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" id="addCustomer"
                                class="px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-200 text-sm transition"
                                title="Tambah Pelanggan Baru">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">Layanan Laundry <span
                                class="text-rose-500">*</span></label>
                        <select id="pos-service" onchange="updateServiceSelection()"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="" disabled selected>-- Pilih Layanan --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-name="{{ $service->service_name }}"
                                    data-price="{{ $service->price_per_unit }}" data-unit="{{ $service->unit }}">
                                    {{ $service->service_name }} - {{ $service->delivery_type }} - Rp
                                    {{ number_format($service->price_per_unit, 0, ',', '.') }} /{{ $service->unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase" id="qty-label">Jumlah /
                            Berat</label>
                        <div class="flex items-center gap-3">
                            <input type="number" id="pos-qty" min="0.1" step="0.1" value="1"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <span class="text-slate-500 text-sm font-semibold" id="qty-unit">-</span>
                        </div>
                        <button type="button" onclick="addToCart()"
                            class="w-full bg-sky-100 text-sky-600 font-bold text-sm py-2 rounded-lg mt-3 hover:bg-sky-200 transition">
                            <i class="fa-solid fa-plus"></i> Tambah ke Keranjang
                        </button>
                    </div>

                    <div class="mt-4 border border-slate-200 rounded-lg overflow-hidden">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr>
                                    <th class="p-2">Layanan</th>
                                    <th class="p-2">Harga</th>
                                    <th class="p-2">Qty</th>
                                    <th class="p-2 text-right">Subtotal</th>
                                    <th class="p-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cart-table-body" class="divide-y divide-slate-200">
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-slate-400">Keranjang masih kosong</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="hidden-cart-inputs"></div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">Metode Pembayaran <span
                                class="text-rose-500">*</span></label>
                        <input type="hidden" name="payment_status" id="payment_status" value="unpaid">
                        <div class="grid grid-cols-2 gap-2">
                            <div onclick="selectPaymentStatus('unpaid')" id="pay-unpaid"
                                class="pay-card border-2 border-rose-500 bg-rose-50 p-3 rounded-xl cursor-pointer hover:border-rose-400 transition flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-800">Bayar di Belakang</h4>
                                    <p class="text-xs text-slate-500">Saat cucian diambil</p>
                                </div>
                                <span class="text-xs font-bold text-rose-500 mt-2">Belum Lunas</span>
                            </div>
                            <div onclick="selectPaymentStatus('paid')" id="pay-paid"
                                class="pay-card border border-slate-200 bg-white p-3 rounded-xl cursor-pointer hover:border-emerald-400 transition flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-800">Bayar di Awal</h4>
                                    <p class="text-xs text-slate-500">Lunas saat drop-off</p>
                                </div>
                                <span class="text-xs font-bold text-emerald-600 mt-2">Lunas</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-5 bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col justify-between">
                    <div>
                        <h3
                            class="font-bold text-slate-700 text-sm border-b border-slate-200 pb-2 mb-3 flex justify-between items-center">
                            <span>Ringkasan Invoice</span>
                            <span class="text-xs bg-sky-700 px-2.5 py-1 rounded-full text-sky-100 font-semibold"
                                id="pos-invoice">
                                NO: {{ $invoiceNumber }}
                            </span>
                        </h3>
                        <div class="flex flex-col gap-3 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Pelanggan:</span>
                                <span class="font-semibold text-slate-800" id="summary-customer">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">No. Telepon:</span>
                                <span class="font-semibold text-slate-800" id="summary-phone">-</span>
                            </div>

                            <div class="border-t border-dashed border-slate-300 my-2"></div>
                            <div class="flex flex-col">
                                <div class="flex justify-between mb-1">
                                    <span class="text-slate-500">Total Item:</span>
                                    <span class="font-semibold text-slate-800" id="summary-total-items">0 Item</span>
                                </div>
                                <ul id="summary-item-list" class="text-slate-600 pl-4 list-decimal flex flex-col gap-1">
                                </ul>
                            </div>

                            <div class="border-t border-dashed border-slate-300 my-2"></div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Metode Pembayaran:</span>
                                <span class="font-semibold text-slate-800" id="summary-payment">Bayar di Belakang</span>
                            </div>

                            <div class="border-t border-dashed border-slate-300 my-2"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800">Total Tagihan:</span>
                                <span class="text-lg font-extrabold text-sky-600" id="summary-total">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-600 text-white font-bold text-sm py-2.5 rounded-lg mt-4 hover:bg-emerald-500 transition shadow-md shadow-emerald-100 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-invoice"></i> Simpan Transaksi
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal Tambah Pelanggan --}}
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadForm">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        // Tampil Modal Tambah Pelanggan Baru
        $(function() {
            $('#addCustomer').on('click', function() {
                $('#customerModal').modal('show');
                $('.modal-title').text('Tambah Pelanggan Baru');
                $('#loadForm').load("{{ route('customers.create') }}");
            });
        });

        // 1. Variabel Global
        let currentService = {
            id: null,
            name: '-',
            price: 0,
            unit: '-'
        };

        let cart = []; // Array untuk menampung banyak layanan di keranjang

        // 2. Fungsi saat Pelanggan dipilih
        function updateSummary() {
            const selectElement = document.getElementById('pos-customer');
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            // Update Ringkasan Pelanggan & No HP
            document.getElementById('summary-customer').innerText = selectedOption.getAttribute('data-name') || '-';
            document.getElementById('summary-phone').innerText = selectedOption.getAttribute('data-phone') || '-';
        }

        // 3. Fungsi saat Layanan Laundry dipilih dari Dropdown
        function updateServiceSelection() {
            const selectElement = document.getElementById('pos-service');
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            // Simpan data layanan ke variabel sementara
            currentService = {
                id: selectElement.value,
                name: selectedOption.getAttribute('data-name'),
                price: parseFloat(selectedOption.getAttribute('data-price')) || 0,
                unit: selectedOption.getAttribute('data-unit') || '-'
            };

            // Update teks satuan (misal: "kg" atau "pcs") di samping input jumlah
            document.getElementById('qty-unit').innerText = currentService.unit;
        }

        // 4. Fungsi untuk Memasukkan Layanan ke Keranjang
        function addToCart() {
            const qty = parseFloat(document.getElementById('pos-qty').value) || 0;

            // Validasi: Cegah masuk keranjang jika layanan belum dipilih
            if (!currentService.id) {
                alert("Pilih layanan laundry terlebih dahulu!");
                return;
            }

            // Kalkulasi subtotal item tersebut
            const subtotal = qty * currentService.price;

            // Masukkan data ke array cart
            cart.push({
                service_id: currentService.id,
                service_name: currentService.name,
                price: currentService.price,
                qty: qty,
                unit: currentService.unit,
                subtotal: subtotal
            });

            // Kembalikan input jumlah ke angka 1 setelah berhasil ditambah
            document.getElementById('pos-qty').value = 1;

            // Panggil fungsi render untuk menggambar ulang tabel dan total tagihan
            renderCart();
        }

        // 5. Fungsi untuk Menghapus Item dari Keranjang
        function removeFromCart(index) {
            cart.splice(index, 1); // Hapus 1 item dari array berdasarkan posisinya (index)
            renderCart(); // Gambar ulang tabel
        }

        // 6. Fungsi untuk Mencetak Tabel Keranjang & Total Tagihan
        function renderCart() {
            const tbody = document.getElementById('cart-table-body');
            const hiddenInputs = document.getElementById('hidden-cart-inputs');
            const summaryItemList = document.getElementById('summary-item-list');

            summaryItemList.innerHTML = '';
            tbody.innerHTML = '';
            hiddenInputs.innerHTML = '';

            let grandTotal = 0;

            if (cart.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="5" class="p-4 text-center text-slate-400">Keranjang masih kosong</td></tr>`;
                document.getElementById('summary-total-items').innerText = '0 Item';
                document.getElementById('summary-total').innerText = 'Rp 0';
                return;
            }

            cart.forEach((item, index) => {
                grandTotal += item.subtotal;

                // 1. Tampilkan baris di Tabel Kiri
                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-2 font-semibold text-slate-700">${item.service_name}</td>
                        <td class="p-2">Rp ${item.price.toLocaleString('id-ID')}</td>
                        <td class="p-2">${item.qty} ${item.unit}</td>
                        <td class="p-2 text-right font-bold text-slate-700">Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                        <td class="p-2 text-center">
                            <button type="button" onclick="removeFromCart(${index})" class="text-rose-500 hover:text-rose-700">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // 2. Buat Hidden Input Array (SANGAT PENTING AGAR DATA TERKIRIM KE CONTROLLER)
                hiddenInputs.innerHTML += `
                    <input type="hidden" name="cart[${index}][service_id]" value="${item.service_id}">
                    <input type="hidden" name="cart[${index}][quantity]" value="${item.qty}">
                `;

                // 3. Tampilkan list di Ringkasan Kanan
                summaryItemList.innerHTML += `
                    <li>
                        <div class="flex justify-between text-[11px] mb-1">
                            <span>${item.service_name}</span>
                            <span class="font-semibold">${item.qty} ${item.unit}</span>
                        </div>
                    </li>
                `;
            });

            document.getElementById('summary-total-items').innerText = `${cart.length} Item`;
            document.getElementById('summary-total').innerText = `Rp ${grandTotal.toLocaleString('id-ID')}`;
        }

        // 7. Fungsi untuk Memilih Status Pembayaran
        function selectPaymentStatus(status) {
            document.getElementById('payment_status').value = status;

            const cardUnpaid = document.getElementById('pay-unpaid');
            const cardPaid = document.getElementById('pay-paid');

            // Reset class default
            cardUnpaid.className =
                "pay-card border border-slate-200 bg-white p-3 rounded-xl cursor-pointer hover:border-rose-400 transition flex flex-col justify-between";
            cardPaid.className =
                "pay-card border border-slate-200 bg-white p-3 rounded-xl cursor-pointer hover:border-emerald-400 transition flex flex-col justify-between";

            if (status === 'unpaid') {
                cardUnpaid.classList.remove('border', 'border-slate-200', 'bg-white');
                cardUnpaid.classList.add('border-2', 'border-rose-500', 'bg-rose-50');
                document.getElementById('summary-payment').innerText = "Bayar di Belakang";
            } else if (status === 'paid') {
                cardPaid.classList.remove('border', 'border-slate-200', 'bg-white');
                cardPaid.classList.add('border-2', 'border-emerald-500', 'bg-emerald-50');
                document.getElementById('summary-payment').innerText = "Bayar di Awal";
            }
        }
        $(document).on('submit', '#form-customer-ajax', function(e) {
            e.preventDefault(); // Mencegah form melakukan refresh halaman

            let form = $(this);
            let url = form.attr('action');

            // Ubah tombol submit jadi loading biar UX lebih mantap
            let submitBtn = form.find('button[type="submit"]');
            let originalText = submitBtn.text();
            submitBtn.text('Menyimpan...').prop('disabled', true);

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // Mengambil semua inputan (nama, telp, csrf)
                success: function(response) {
                    if (response.status === 'success') {
                        // 1. Tutup modal
                        $('#customerModal').modal('hide');

                        // 2. Buat elemen Option baru untuk dropdown
                        let newCustomer = response.data;

                        // Gunakan fallback || jika nama property object di DB Anda bervariasi
                        let customerName = newCustomer.customer_name || newCustomer.nama_customer;
                        let customerPhone = newCustomer.customer_phone || newCustomer.no_tlp;

                        let optionText = customerName + ' (' + customerPhone + ')';
                        let newOption = new Option(optionText, newCustomer.id, true, true);

                        // Set atribut data agar fungsi updateSummary() kita tetap jalan
                        newOption.setAttribute('data-name', customerName);
                        newOption.setAttribute('data-phone', customerPhone);

                        // 3. Masukkan ke select dropdown dan trigger perubahan
                        $('#pos-customer').append(newOption).trigger('change');

                        // 4. Update ringkasan sebelah kanan
                        updateSummary();

                        // 5. Tampilkan SweetAlert Sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pelanggan Berhasil Ditambahkan.',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    // TAMPILKAN SWEETALERT2 BERWARNA MERAH JIKA VALIDASI GAGAL ATAU SYSTEM ERROR
                    Swal.fire({
                        title: 'Gagal Menyimpan!',
                        text: 'Terjadi kesalahan. Pastikan seluruh form input terisi dengan benar.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });

                    // Kembalikan tombol ke status semula
                    submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    </script>
@endpush
