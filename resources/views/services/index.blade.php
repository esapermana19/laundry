@extends('layouts.vuexy')
@section('page-title', 'Services')
@section('content')
    {{-- Filter Data Layanan --}}
    <div class="card">
        <div class="card-body">
            <form action="/services" method="GET">
                <div class="row g-3 align-items-center">
                    {{-- Input Search Name --}}
                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" name="service_name" class="form-control" placeholder="Service Name"
                                value="{{ Request('service_name') }}" aria-label="Search...">
                        </div>
                    </div>

                    {{-- Select Satuan --}}
                    <div class="col-md-3 col-12">
                        <select id="unit" name="unit" class="form-select">
                            <option value="">Pilih Satuan</option>
                            <option value="Kg" {{ Request('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
                            <option value="Pcs" {{ Request('unit') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        </select>
                    </div>

                    {{-- Group Tombol Action (Search & Reset) --}}
                    <div class="col-md-3 col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-info w-100 px-2">
                                <i class="ti ti-search"></i> Search
                            </button>
                            <button type="button" class="btn btn-secondary w-100 px-2"
                                onclick="window.location='/services'">
                                <i class="ti ti-refresh"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Tabel Data Layanan --}}
    <div class="card mt-3">
        <div class="card-body">
            <a href="#" id="btnTambahData" class="btn btn-primary">Tambah Data</a>
            <table class="table mb-2">
                <thead>
                    <tr>
                        <th>Kode Layanan</th>
                        <th>Nama Layanan</th>
                        <th>Satuan</th>
                        <th>Tipe Pengiriman</th>
                        <th>Harga</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($service as $s)
                        <tr>
                            <td>{{ $s->service_code }}</td>
                            <td>{{ $s->service_name }}</td>
                            <td>{{ $s->unit }}</td>
                            <td>{{ $s->delivery_type }}</td>
                            <td>{{ $s->price_per_unit }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info btnEdit" data-id="{{ $s->id }}">Edit</a>
                                <form action="{{ route('services.destroy', $s->id) }}" method="POST"
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
            {{ $service->links() }}
        </div>
    </div>
    {{-- Modal Form Tambah/Edit Layanan --}}
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="true">
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
                $("#serviceModal").modal("show");
                $(".modal-title").text("Tambah Layanan");
                $("#loadForm").load("/services/create");
            });

            //edit
            $(document).on('click', '.btnEdit', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $("#serviceModal").modal("show");
                $(".modal-title").text("Edit Layanan");
                $("#loadForm").load("/services/edit/" + id);
            })
            $(".formDelete").submit(function(e) {
                e.preventDefault();
                let form = this;
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data Layanan akan dihapus!",
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
