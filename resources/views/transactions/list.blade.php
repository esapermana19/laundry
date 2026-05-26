@extends('layouts.vuexy')
@section('page-title','order list')
@section('content')
<div id="screen-tracking"
    class="screen-view w-full max-w-4xl bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
    <!-- Top Bar -->
    <div class="p-4 bg-indigo-600 text-white flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-spinner"></i>
            <span class="font-bold tracking-wide">Monitoring Status Laundry</span>
        </div>
        <span class="text-xs bg-indigo-700 px-3 py-1 rounded-full text-indigo-100 font-semibold flex items-center gap-1">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-ping"></span>
            Realtime Update
        </span>
    </div>

    <!-- Filter & Search -->
    <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="relative w-full sm:w-72">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-sm"></i>
            <input type="text" placeholder="Cari Nota atau Pelanggan..."
                class="w-full pl-9 pr-4 py-1.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex gap-2">
            <span class="text-xs text-slate-500 self-center font-medium">Klik status untuk mengubah progres secara
                langsung:</span>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr
                    class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <th class="p-4">No. Invoice</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Layanan</th>
                    <th class="p-4">Status Cucian (Alur)</th>
                    <th class="p-4">Pembayaran</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700" id="tracking-table-body">
                <tr class="hover:bg-slate-50 border-b border-slate-100 transition">
                    <td class="p-4 font-mono font-bold text-slate-700">WF-20260519-001</td>
                    <td class="p-4 font-semibold text-slate-800">Budi Santoso</td>
                    <td class="p-4 font-medium text-slate-500">Cuci Setrika Kiloan (3.0 kg)</td>
                    <td class="p-4">
                        <div class="flex gap-1">
                            <button onclick="updateOrderStatus(1, 'received')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-sky-500 text-white font-bold ring-2 ring-sky-200 scale-105">
                                Diterima
                            </button>

                            <button onclick="updateOrderStatus(1, 'washing')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Cuci
                            </button>

                            <button onclick="updateOrderStatus(1, 'drying')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Kering
                            </button>

                            <button onclick="updateOrderStatus(1, 'ironing')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Setrika
                            </button>

                            <button onclick="updateOrderStatus(1, 'ready')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Siap
                            </button>

                            <button onclick="updateOrderStatus(1, 'completed')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Selesai
                            </button>
                        </div>
                    </td>
                    <td class="p-4"><span
                            class="px-2 py-0.5 bg-rose-50 text-rose-700 font-bold rounded-full border border-rose-100">Belum
                            Lunas</span></td>
                    <td class="p-4">
                        <button onclick="deleteOrderMock(1)"
                            class="px-2 py-1 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded transition text-xs"
                            title="Hapus orderan">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b border-slate-100 transition">
                    <td class="p-4 font-mono font-bold text-slate-700">WF-20260519-002</td>
                    <td class="p-4 font-semibold text-slate-800">Siti Aminah</td>
                    <td class="p-4 font-medium text-slate-500">Bedcover King (1.0 pcs)</td>
                    <td class="p-4">
                        <div class="flex gap-1">
                            <button onclick="updateOrderStatus(2, 'received')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-emerald-100 text-emerald-800 font-medium">
                                Diterima
                            </button>

                            <button onclick="updateOrderStatus(2, 'washing')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-sky-500 text-white font-bold ring-2 ring-sky-200 scale-105">
                                Cuci
                            </button>

                            <button onclick="updateOrderStatus(2, 'drying')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Kering
                            </button>

                            <button onclick="updateOrderStatus(2, 'ironing')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Setrika
                            </button>

                            <button onclick="updateOrderStatus(2, 'ready')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Siap
                            </button>

                            <button onclick="updateOrderStatus(2, 'completed')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Selesai
                            </button>
                        </div>
                    </td>
                    <td class="p-4"><span
                            class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-full border border-emerald-100">Lunas</span>
                    </td>
                    <td class="p-4">
                        <button onclick="deleteOrderMock(2)"
                            class="px-2 py-1 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded transition text-xs"
                            title="Hapus orderan">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b border-slate-100 transition">
                    <td class="p-4 font-mono font-bold text-slate-700">WF-20260519-003</td>
                    <td class="p-4 font-semibold text-slate-800">Andi Wijaya</td>
                    <td class="p-4 font-medium text-slate-500">Cuci Setrika Kiloan (4.2 kg)</td>
                    <td class="p-4">
                        <div class="flex gap-1">
                            <button onclick="updateOrderStatus(3, 'received')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-emerald-100 text-emerald-800 font-medium">
                                Diterima
                            </button>

                            <button onclick="updateOrderStatus(3, 'washing')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-emerald-100 text-emerald-800 font-medium">
                                Cuci
                            </button>

                            <button onclick="updateOrderStatus(3, 'drying')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-emerald-100 text-emerald-800 font-medium">
                                Kering
                            </button>

                            <button onclick="updateOrderStatus(3, 'ironing')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-emerald-100 text-emerald-800 font-medium">
                                Setrika
                            </button>

                            <button onclick="updateOrderStatus(3, 'ready')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-sky-500 text-white font-bold ring-2 ring-sky-200 scale-105">
                                Siap
                            </button>

                            <button onclick="updateOrderStatus(3, 'completed')"
                                class="px-2 py-1 text-[10px] rounded-md border border-slate-200/50 transition cursor-pointer hover:opacity-85 bg-slate-100 text-slate-400">
                                Selesai
                            </button>
                        </div>
                    </td>
                    <td class="p-4"><span
                            class="px-2 py-0.5 bg-rose-50 text-rose-700 font-bold rounded-full border border-rose-100">Belum
                            Lunas</span></td>
                    <td class="p-4">
                        <button onclick="deleteOrderMock(3)"
                            class="px-2 py-1 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded transition text-xs"
                            title="Hapus orderan">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
