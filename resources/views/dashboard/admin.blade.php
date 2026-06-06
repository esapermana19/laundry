@extends('layouts.vuexy')
@section('page-title', 'Dashboard Ringkasan')
@section('content')

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5 class="mb-0 fw-bold" style="font-size: 15px;">Laporan Pendapatan</h5>
                    <small class="text-muted">Ringkasan Mingguan Pendapatan</small>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <div class="col-md-5 border-end pe-md-4">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <h2 class="mb-0 me-2 fw-bold text-primary" style="font-size: 26px;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h2>
                            <span class="badge bg-label-success" style="font-size: 11px;">+4.2%</span>
                        </div>
                        <p class="text-muted small mb-0">Total omset bersih dari seluruh pesanan laundry yang telah lunas pada periode ini.</p>
                    </div>
                    <div class="col-md-7 ps-md-4">
                        <div style="height: 170px; width: 100%;">
                            <canvas id="omsetChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="border-top mt-4 pt-3">
                    <div class="row g-3 text-center">
                        <div class="col-4 border-end">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                <span class="badge bg-label-primary p-1 rounded"><i class="ti ti-currency-dollar fs-6"></i></span>
                                <h6 class="mb-0 text-muted" style="font-size: 12px;">Omset</h6>
                            </div>
                            <h5 class="mb-0 fw-bold text-heading" style="font-size: 14px;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-4 border-end">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                <span class="badge bg-label-success p-1 rounded"><i class="ti ti-file-invoice fs-6"></i></span>
                                <h6 class="mb-0 text-muted" style="font-size: 12px;">Transaksi</h6>
                            </div>
                            <h5 class="mb-0 fw-bold text-heading" style="font-size: 14px;">{{ $totalTransaksi }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                <span class="badge bg-label-warning p-1 rounded"><i class="ti ti-shirt fs-6"></i></span>
                                <h6 class="mb-0 text-muted" style="font-size: 12px;">Proses</h6>
                            </div>
                            <h5 class="mb-0 fw-bold text-heading" style="font-size: 14px;">{{ $cucianDiproses }}</h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('omsetChart').getContext('2d');

        // Mengambil data array real dari PHP Controller
        const labelsData = @json($chartLabels);
        const revenueData = @json($chartData);

        // Modifikasi label hari agar lebih pendek (Misal: "31 May" jadi "31") untuk estetika ringkas
        const shortLabels = labelsData.map(label => label.split(' ')[0]);

        // Efek warna: Hari terakhir dibuat ungu pekat khas Vuexy (#7367F0), hari lain ungu transparan
        const bgColors = revenueData.map((val, index) => {
            return index === revenueData.length - 1 ? '#7367F0' : 'rgba(115, 103, 240, 0.16)';
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: shortLabels,
                datasets: [{
                    label: 'Omset',
                    data: revenueData,
                    backgroundColor: bgColors,
                    borderRadius: 6, // Membuat ujung batang melengkung bulat halus
                    borderSkipped: false,
                    maxBarThickness: 15 // Mengatur ketebalan batang agar tetap elegan
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda kotak atas
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: false // Sembunyikan garis grid dan angka sumbu Y agar bersih
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                family: 'Public Sans, sans-serif'
                            },
                            color: '#a1a0ea'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
