@extends('layouts.vuexy')
@section('page-title', 'Dashboard Ringkasan')
@section('content')

<div class="row g-3">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase style font-semibold" style="font-size: 11px;">Total Omset (Lunas)</h6>
                    <h4 class="mb-0 fw-bold text-emerald-600">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h4>
                </div>
                <div class="badge bg-label-success p-2 rounded">
                    <i class="ti ti-currency-dollar fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase font-semibold" style="font-size: 11px;">Total Pesanan</h6>
                    <h4 class="mb-0 fw-bold">{{ $totalTransaksi }}</h4>
                </div>
                <div class="badge bg-label-primary p-2 rounded">
                    <i class="ti ti-file-invoice fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase font-semibold" style="font-size: 11px;">Sedang Diproses</h6>
                    <h4 class="mb-0 fw-bold text-warning">{{ $cucianDiproses }} <span class="text-muted fw-normal" style="font-size: 12px;">Antrean</span></h4>
                </div>
                <div class="badge bg-label-warning p-2 rounded">
                    <i class="ti ti-shirt fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase font-semibold" style="font-size: 11px;">Pelanggan Terdaftar</h6>
                    <h4 class="mb-0 fw-bold">{{ $totalPelanggan }} <span class="text-muted fw-normal" style="font-size: 12px;">Orang</span></h4>
                </div>
                <div class="badge bg-label-info p-2 rounded">
                    <i class="ti ti-users fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-3 pb-0">
                <h5 class="card-title mb-0 fw-bold" style="font-size: 14px;">Grafik Pendapatan (7 Hari Terakhir)</h5>
                <small class="text-muted">Real-time tren omset harian toko laundry</small>
            </div>
            <div class="card-body p-3">
                <div style="height: 250px; width: 100%;">
                    <canvas id="omsetChart"></canvas>
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

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Omset Harian (Rp)',
                    data: revenueData,
                    borderColor: '#0284c7', // Warna sky-600
                    backgroundColor: 'rgba(2, 132, 199, 0.1)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3, // Membuat garis grafik melengkung halus (smooth)
                    pointBackgroundColor: '#0284c7',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan label kotak atas agar ringkas
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 },
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    x: {
                        ticks: { font: { size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
