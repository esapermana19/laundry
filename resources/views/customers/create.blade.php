<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Kode Customer</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                <input type="text" class="form-control" name="customer_code" placeholder="Cth: CS-001">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Customer</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-user"></i></span>
                <input type="text" class="form-control" name="customer_name" placeholder="Cth: Esa Permana">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">No.Tlp</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-phone"></i></span>
                <input type="number" class="form-control" name="customer_phone" placeholder="Cth: 0823xxxxxx">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                <input type="text" class="form-control" name="customer_address" placeholder="Cth: Jl. Merdeka No. 123">
            </div>
        </div>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
        <button type="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
    </div>
</form>
