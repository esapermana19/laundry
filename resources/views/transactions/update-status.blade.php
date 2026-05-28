<form action="/transactions/update-status-save/{{ $transaction->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="status" id="modal_status" value="{{ $transaction->status }}">
    <input type="hidden" name="payment_status" id="modal_payment" value="{{ $transaction->payment_status }}">

    <div class="mb-3">
        <label class="block text-[11px] font-bold text-slate-500 mb-1.5 uppercase">Proses Laundry</label>
        <div class="grid grid-cols-3 gap-1.5">

            <div onclick="setModalStatus('received')" id="card-received"
                class="status-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Diterima</h4>
                <p class="text-[9px] text-slate-500 leading-tight mt-0.5">Di kasir</p>
            </div>

            <div onclick="setModalStatus('washing')" id="card-washing"
                class="status-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Dicuci</h4>
                <p class="text-[9px] text-slate-500 leading-tight mt-0.5">Masuk mesin</p>
            </div>

            <div onclick="setModalStatus('drying')" id="card-drying"
                class="status-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Kering</h4>
                <p class="text-[9px] text-slate-500 leading-tight mt-0.5">Pengeringan</p>
            </div>

            <div onclick="setModalStatus('ironing')" id="card-ironing"
                class="status-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Setrika</h4>
                <p class="text-[9px] text-slate-500 leading-tight mt-0.5">Finishing</p>
            </div>

            <div onclick="setModalStatus('ready')" id="card-ready"
                class="status-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Siap</h4>
                <p class="text-[9px] text-slate-500 leading-tight mt-0.5">Bisa diambil</p>
            </div>

            <div onclick="setModalStatus('completed')" id="card-completed"
                class="status-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Selesai</h4>
                <p class="text-[9px] text-slate-500 leading-tight mt-0.5">Diserahkan</p>
            </div>

        </div>
    </div>

    <hr class="my-2 border-slate-200">

    <div class="mb-3">
        <label class="block text-[11px] font-bold text-slate-500 mb-1.5 uppercase">Status Pembayaran</label>
        <div class="grid grid-cols-2 gap-1.5">

            <div onclick="setModalPayment('unpaid')" id="card-unpaid"
                class="payment-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-rose-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Belum Lunas</h4>
                <p class="text-[9px] font-bold text-rose-500 mt-0.5">Rp
                    {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>

            <div onclick="setModalPayment('paid')" id="card-paid"
                class="payment-card border border-slate-200 p-1.5 rounded-lg cursor-pointer hover:border-emerald-400 transition text-center">
                <h4 class="font-bold text-xs text-slate-800">Lunas</h4>
                <p class="text-[9px] font-bold text-emerald-600 mt-0.5">Sudah Dibayar</p>
            </div>

        </div>
    </div>

    <div class="mt-3 text-end">
        <button type="button" class="btn btn-sm btn-label-secondary me-2" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan</button>
    </div>
</form>

<script>
    // 1. Ambil status asli dari Database saat modal dibuka
    const initialStatus = '{{ $transaction->status }}';
    const initialPayment = '{{ $transaction->payment_status }}';

    // 2. Buat urutan ranking (hirarki) status laundry
    const statusRanks = {
        'received': 0,
        'washing': 1,
        'drying': 2, // Pengeringan
        'ironing': 3,
        'ready': 4,
        'completed': 5
    };

    // Fungsi bantuan untuk men-disable kartu secara visual & fungsi
    function disableCard(cardId) {
        let card = document.getElementById(cardId);
        if (card) {
            // Hapus efek hover & kursor pointer
            card.classList.remove('cursor-pointer', 'hover:border-sky-400', 'hover:border-rose-400',
                'hover:border-emerald-400');
            // Tambahkan efek pudar dan dilarang klik
            card.classList.add('opacity-50', 'cursor-not-allowed', 'bg-slate-100');
            // Matikan fungsi klik
            card.removeAttribute('onclick');
        }
    }

    function setModalStatus(status) {
        document.getElementById('modal_status').value = status;

        // Reset semua kartu, KECUALI yang sedang di-disable
        document.querySelectorAll('.status-card').forEach(card => {
            if (!card.classList.contains('cursor-not-allowed')) {
                card.className =
                    "status-card border border-slate-200 bg-white p-1.5 rounded-lg cursor-pointer hover:border-sky-400 transition text-center";
            }
        });

        // Warnai kartu yang diklik
        let activeCard = document.getElementById('card-' + status);
        if (activeCard && !activeCard.classList.contains('cursor-not-allowed')) {
            activeCard.classList.remove('border-slate-200', 'bg-white');
            activeCard.classList.add('border-2', 'border-sky-500', 'bg-sky-50');
        }
    }

    function setModalPayment(status) {
        document.getElementById('modal_payment').value = status;

        // Reset semua kartu payment, KECUALI yang di-disable
        document.querySelectorAll('.payment-card').forEach(card => {
            if (!card.classList.contains('cursor-not-allowed')) {
                card.className =
                    "payment-card border border-slate-200 bg-white p-1.5 rounded-lg cursor-pointer transition text-center";
            }
        });

        // Warnai kartu payment
        let activeCard = document.getElementById('card-' + status);
        if (activeCard && !activeCard.classList.contains('cursor-not-allowed')) {
            if (status === 'unpaid') {
                activeCard.classList.remove('border-slate-200', 'bg-white');
                activeCard.classList.add('border-2', 'border-rose-500', 'bg-rose-50');
            } else {
                activeCard.classList.remove('border-slate-200', 'bg-white');
                activeCard.classList.add('border-2', 'border-emerald-500', 'bg-emerald-50');
            }
        }
    }

    // JALANKAN OTOMATIS SAAT MODAL TERBUKA
    setTimeout(() => {
        // Tandai status yang sedang aktif
        setModalStatus(initialStatus);
        setModalPayment(initialPayment);

        // LOGIKA 1: Jika status sudah di Pengeringan (rank >= 2), disable status sebelumnya
        if (statusRanks[initialStatus] >= 2) {
            for (let key in statusRanks) {
                if (statusRanks[key] < statusRanks[initialStatus]) {
                    disableCard('card-' + key);
                }
            }
        }

        // LOGIKA 2: Jika sudah lunas, matikan tombol 'Belum Lunas'
        if (initialPayment === 'paid') {
            disableCard('card-unpaid');
        }
    }, 100);
</script>
