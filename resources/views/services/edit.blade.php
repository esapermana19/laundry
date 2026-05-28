<form action="{{ route('services.update', $service->id) }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Kode Layanan</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                <input type="text" class="form-control" name="service_code" value="{{$service->service_code}}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Layanan</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-receipt"></i></span>
                <input type="text" class="form-control" name="service_name" value="{{$service->service_name}}">
            </div>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="ti ti-category"></i>
                </span>
                <select id="unit" name="unit" class="form-select border-start-0 pl-2">
                    <option value="kg" {{ $service->unit === 'kg' ? 'selected' : '' }}>Kg</option>
                    <option value="pcs" {{ $service->unit === 'pcs' ? 'selected' : '' }}>Pcs</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="ti ti-category"></i>
                </span>
                <select id="delivery_type" name="delivery_type" class="form-select border-start-0 pl-2">
                    <option value="ambil" {{ $service->delivery_type === 'ambil' ? 'selected' : '' }}>Ambil</option>
                    <option value="antar" {{ $service->delivery_type === 'antar' ? 'selected' : '' }}>Antar</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga per Satuan</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-money"></i></span>
                <input type="number" class="form-control" name="price_per_unit" value="{{$service->price_per_unit}}" placeholder="0">
            </div>
        </div>
        <button type="button" onclick="btnConfirm()" class="btn btn-primary waves-effect waves-light">Simpan</button>
        <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
<script>
    function btnConfirm() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
                    text: "Data Layanan akan diubah!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, ubah!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika ditekan "Ya", form disubmit secara terprogram
                document.getElementById('form-edit').submit();
            }
        });
    }
</script>
