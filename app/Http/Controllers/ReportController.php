<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        // Default rentang tanggal jika user baru membuka halaman (awal bulan ini s/d hari ini)
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Ambil data transaksi lunas pada rentang tanggal tersebut beserta data kustomernya
        $transactions = Transaction::with('customer')
            ->where('payment_status', 'paid')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date', 'asc')
            ->get();

        // Hitung total omset dari data yang difilter
        $totalOmset = $transactions->sum('total_price');

        return view('transactions.report', compact('transactions', 'totalOmset', 'startDate', 'endDate'));
    }
}
