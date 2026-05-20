@extends('layouts.vuexy')

@section('title', 'Data Pelanggan')
@section('content')
    <div class="card">
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
