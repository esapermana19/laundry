<form action="{{ route('services.store') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Kode Layanan</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                <input type="text" class="form-control" name="service_code" placeholder="SERV01">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Layanan</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-receipt"></i></span>
                <input type="text" class="form-control" name="service_name" placeholder="Cth: Cuci Setrika">
            </div>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="ti ti-category"></i>
                </span>
                <select id="unit" name="unit" class="form-select border-start-0 pl-2">
                    <option value="kg">Kg</option>
                    <option value="pcs">Pcs</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="ti ti-category"></i>
                </span>
                <select id="delivery_type" name="delivery_type" class="form-select border-start-0 pl-2">
                    <option value="ambil">Ambil</option>
                    <option value="antar">Antar</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga per Satuan</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-money"></i></span>
                <input type="number" class="form-control" name="price_per_unit" placeholder="0">
            </div>
        </div>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
        <button type="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
    </div>
</form>
