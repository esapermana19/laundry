@extends('layouts.vuexy')
@section('page-title', 'Laporan Pendapatan')
@section('content')

<div class="card mb-3 d-print-none">
    <div class="card-body p-3">
        <form action="{{ route('transactions.report') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-4 col-12">
                    <label class="form-label font-semibold text-muted text-uppercase" style="font-size: 10px;">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                </div>
                <div class="col-md-4 col-12">
                    <label class="form-label font-semibold text-muted text-uppercase" style="font-size: 10px;">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="ti ti-filter me-1"></i> Filter
                    </button>
                    <button type="button" onclick="window.print()" class="btn btn-success btn-sm w-100">
                        <i class="ti ti-printer me-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-report">
    <div class="card-body p-3">
        <div class="d-none d-print-block text-center mb-4">
            <h3 class="mb-1 fw-bold">JACUSA LAUNDRY</h3>
            <p class="mb-1" style="font-size: 13px;">Laporan Pendapatan Omset Laundry (Lunas)</p>
            <small class="text-muted">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</small>
            <hr class="mt-3" style="border-top: 2px solid #000;">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0 fw-bold graphical-title" style="font-size: 14px;">Rekapitulasi Transaksi</h5>
                <small class="text-muted d-print-none">Menampilkan {{ $transactions->count() }} data lunas terpilih</small>
            </div>
            <div class="text-end">
                <span class="text-muted text-uppercase d-block" style="font-size: 10px; font-weight: 600;">Total Omset Terpilih</span>
                <h4 class="mb-0 fw-bold text-emerald-600">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h4>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-sm m-0" style="font-size: 12px;">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%;">No.</th>
                        <th style="width: 15%;">Tgl. Transaksi</th>
                        <th style="width: 20%;">No. Invoice</th>
                        <th>Nama Pelanggan</th>
                        <th class="text-end" style="width: 20%;">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</td>
                            <td class="font-semibold text-primary">{{ $transaction->invoice_number }}</td>
                            <td>{{ $transaction->customer->customer_name }}</td>
                            <td class="text-end font-semibold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-muted">
                                <i class="ti ti-box-off d-block text-xl mb-2"></i> Tidak ada data pendapatan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($transactions->isNotEmpty())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Grand Total Pendapatan:</td>
                            <td class="text-end text-emerald-700" style="font-size: 13px;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</td>
                        </tr>
                    </footer>
                @endif
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Sembunyikan navbar, sidebar, footer bawaan Vuexy */
        .layout-navbar, .layout-menu, .footer, .content-footer, .d-print-none {
            display: none !important;
        }
        /* Lebarkan area konten utama hingga penuh */
        .layout-page, .content-wrapper, .container-xxl, .card-report {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }
        body {
            background-color: #fff !important;
        }
    }
</style>

@endsection
