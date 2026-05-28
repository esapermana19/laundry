<form action="{{ route('customers.update', $customer->id) }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Kode Customer</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                <input type="text" class="form-control" name="customer_code" value="{{ $customer->customer_code }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Customer</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-user"></i></span>
                <input type="text" class="form-control" name="customer_name" value="{{ $customer->customer_name }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">No.Tlp</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-phone"></i></span>
                <input type="number" class="form-control" name="customer_phone"
                    value="{{ $customer->customer_phone }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                <input type="text" class="form-control" name="customer_address"
                    value="{{ $customer->customer_address }}">
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
                    text: "Data Customer akan diubah!",
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
