@extends('layouts.vuexy')

@section('title', 'Data Pelanggan')
@section('content')
    {{-- Filter Data Pelanggan --}}
    <div class="card">
        <div class="card-body">
            <form action="/services" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" name="service_name" class="form-control" placeholder="Service Name"
                                value="{{ Request('service_name') }}" aria-label="Search..."
                                aria-describedby="basic-addon-search31">
                        </div>
                    </div>
                    <div class="col-4">
                        <select id="category_id" name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            {{-- @foreach ($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ Request('category_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->category_name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-info">
                            <i class="ti ti-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Tabel Data Pelanggan --}}
    <div class="card mt-3">
        <div class="card-body">
            <a href="#" id="btnTambahData" class="btn btn-primary">Tambah Data</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Customer</th>
                        <th>Nama Customer</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $c)
                        <tr>
                            <td>{{ $c->customer_code }}</td>
                            <td>{{ $c->customer_name }}</td>
                            <td>{{ $c->customer_phone }}</td>
                            <td>{{ $c->customer_address }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info btnEdit" data-id="{{ $c->id }}">Edit</a>
                                <form action="{{ route('customers.destroy', $c->id) }}" method="POST"
                                    class="d-inline formDelete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Modal Form Tambah/Edit Pelanggan --}}
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
        $(function() {
            //Tambah
            $("#btnTambahData").click(function() {
                $("#customerModal").modal("show");
                $(".modal-title").text("Tambah Customer");
                $("#loadForm").load("/customers/create");
            });

            //edit
            $(document).on('click', '.btnEdit', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $("#customerModal").modal("show");
                $(".modal-title").text("Edit Customer");
                $("#loadForm").load("/customers/edit/" + id);
            })
            $(".formDelete").submit(function(e) {
                e.preventDefault();
                let form = this;
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data Customer akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endpush
