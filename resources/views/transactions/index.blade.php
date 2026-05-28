@extends('layouts.vuexy');
@section('page-title', 'Sales')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('transactions.create') }}" id="btnTambahData" class="btn btn-primary btn-sm mb-3">Tambah Data</a>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover table-sm mb-3" style="font-size: 13px;">
                    <thead>
                        <tr class="text-uppercase" style="font-size: 11px;">
                            <th>No.</th>
                            <th>No. Invoice</th>
                            <th>Nama Pelanggan</th>
                            <th>Tgl. Transaksi</th>
                            <th>Tgl. Pengambilan</th>
                            <th>Total</th>
                            <th>Status Bayar</th>
                            <th>Status Order</th>
                            <th class="text-center">Faktur</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-semibold">{{ $transaction->invoice_number }}</td>
                                <td>{{ $transaction->customer->customer_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</td>

                                <td>
                                    {{ $transaction->taken_date ? \Carbon\Carbon::parse($transaction->taken_date)->format('d M Y') : '-' }}
                                </td>

                                <td class="font-semibold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if ($transaction->payment_status == 'paid')
                                        <span class="badge bg-emerald-400 text-emerald-800"
                                            style="font-size: 11px; padding: 4px 8px;">Lunas</span>
                                    @else
                                        <span class="badge bg-rose-400 text-rose-800"
                                            style="font-size: 11px; padding: 4px 8px;">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'received' => 'bg-blue-400 text-blue-800',
                                            'washing' => 'bg-yellow-400 text-yellow-800',
                                            'drying' => 'bg-orange-400 text-orange-800',
                                            'ironing' => 'bg-purple-400 text-purple-800',
                                            'ready' => 'bg-green-400 text-green-800',
                                            'completed' => 'bg-gray-400 text-gray-800',
                                        ];
                                        $colorClass = $statusColors[$transaction->status] ?? 'bg-slate-400 text-slate-800';
                                    @endphp
                                    <span class="badge {{ $colorClass }}"
                                        style="font-size: 11px; padding: 4px 8px; text-transform: capitalize;">
                                        {{ str_replace('_', ' ', $transaction->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('transactions.print', $transaction->id) }}" target="_blank"
                                        class="text-primary hover:text-secondary">
                                        <i class="ti ti-file-description fs-5"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#"
                                        class="orderStatus font-semibold"
                                        data-id="{{ $transaction->id }}"><i class="ti ti-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center p-4 text-muted">
                                    <i class="ti ti-box-off d-block text-xl mb-2"></i> Belum ada transaksi masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- modal update status --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
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
            $(document).on('click', '.orderStatus', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $("#statusModal").modal("show");
                $(".modal-title").text("Update Status");
                $("#loadForm").load("/transactions/update-status/" + id);
            });
        });
    </script>
@endpush
