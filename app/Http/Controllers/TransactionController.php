<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailTransaction;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $transactions = Transaction::with('customer')->orderBy('created_at', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format tanggal hari ini (Contoh: 20260526)
        $tanggal = now()->format('Ymd');

        // 2. Cari transaksi terakhir yang dibuat hari ini di database
        $lastTransaction = Transaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        // 3. Logika penomoran urut
        if ($lastTransaction && $lastTransaction->invoice_number) {
            // Jika hari ini sudah ada transaksi, ambil 3 angka terakhir lalu tambah 1
            $urut = (int) substr($lastTransaction->invoice_number, -3);
            $urut++;
            $nomor_urut = sprintf("%03s", $urut); // Memaksa jadi 3 digit (contoh: 002, 015)
        } else {
            // Jika belum ada transaksi sama sekali hari ini, mulai dari 001
            $nomor_urut = "001";
        }

        // 4. Gabungkan semuanya menjadi 15 Karakter
        $invoiceNumber = 'INV-' . $tanggal . $nomor_urut;

        // (Data master lainnya seperti customers dan services)
        $customers = Customer::all();
        $services = Service::all();

        // 5. Lempar variabel $invoiceNumber ke View
        return view('transactions.create', compact('customers', 'services', 'invoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Ubah ke sistem keranjang/array)
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'payment_status' => 'required|in:paid,unpaid',
            'cart'           => 'required|array|min:1', // Memastikan keranjang tidak kosong
            'cart.*.service_id' => 'required|exists:services,id',
            'cart.*.quantity'   => 'required|numeric|min:0.1',
        ], [
            'cart.required' => 'Keranjang layanan laundry tidak boleh kosong. Silakan tambah layanan dulu!',
        ]);

        DB::beginTransaction();

        try {
            // 2. Hitung Grand Total harga dari seluruh isi keranjang di backend
            $grandTotal = 0;
            foreach ($request->cart as $item) {
                $service = Service::findOrFail($item['service_id']);
                $grandTotal += ($service->price_per_unit * $item['quantity']);
            }

            // 3. Generate Nomor Invoice Baru
            $datePrefix = date('Ymd');
            $lastTransaction = Transaction::whereDate('created_at', date('Y-m-d'))->count();
            $invoiceNumber = 'INV-' . $datePrefix . str_pad($lastTransaction + 1, 3, '0', STR_PAD_LEFT);

            // 4. Insert ke tabel `transactions` (Tabel Utama)
            $transaction = Transaction::create([
                'invoice_number'   => $invoiceNumber,
                'customer_id'      => $request->customer_id,
                'user_id'          => Auth::id(),
                'total_price'      => $grandTotal, // Pakai grand total dari keranjang
                'payment_status'   => $request->payment_status,
                'status'           => 'received',
                'transaction_date' => now()->toDateString(),
            ]);

            // 5. Looping untuk Insert ke tabel `transaction_details`
            foreach ($request->cart as $item) {
                $service = Service::findOrFail($item['service_id']);

                DetailTransaction::create([
                    'transaction_id' => $transaction->id,
                    'service_id'     => $service->id,
                    'quantity'       => $item['quantity'],
                    'price'          => $service->price_per_unit,
                    'subtotal'       => $service->price_per_unit * $item['quantity'],
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.create')
                ->with('success', 'Transaksi berhasil disimpan dengan No Invoice: ' . $invoiceNumber);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
