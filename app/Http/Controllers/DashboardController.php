<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // 1. HITUNG STATISTIK UTAMA (DATA REAL)
        $totalOmset = Transaction::where('payment_status', 'paid')->sum('total_price');
        $totalTransaksi = Transaction::count();

        // Cucian diproses (selain yang 'completed')
        $cucianDiproses = Transaction::whereIn('status', ['received', 'washing', 'drying', 'ironing', 'ready'])->count();
        $totalPelanggan = Customer::count();

        // 2. DATA REAL UNTUK GRAFIK (7 Hari Terakhir)
        $charts = Transaction::select(
            DB::raw('DATE(transaction_date) as tanggal'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('payment_status', 'paid')
            ->where('transaction_date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->get();

        // Format data agar siap dibaca oleh Chart.js
        $chartLabels = [];
        $chartData = [];

        // Looping untuk mengisi hari yang kosong jika ada hari tanpa transaksi
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $label = now()->subDays($i)->format('d M');

            $chartLabels[] = $label;

            // Cari apakah ada omset di tanggal ini
            $match = $charts->firstWhere('tanggal', $date);
            $chartData[] = $match ? (int) $match->total : 0;
        }

        return view('dashboard.admin', compact(
            'totalOmset',
            'totalTransaksi',
            'cucianDiproses',
            'totalPelanggan',
            'chartLabels',
            'chartData'
        ));
    }
}
