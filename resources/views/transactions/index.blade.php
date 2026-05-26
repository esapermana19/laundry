@extends('layouts.vuexy');
@section('page-title', 'Sales')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{route('transactions.create')}}" id="btnTambahData" class="btn btn-primary">Tambah Data</a>
            {{-- <form action="/products" method="GET">
                <div class="row mt-2 mb-2">
                    <div class="col-6">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" name="product_name" class="form-control" placeholder="Product Name"
                                value="{{ Request('product_name') }}" aria-label="Search..."
                                aria-describedby="basic-addon-search31">
                        </div>
                    </div>
                    <div class="col-4">
                        <select id="category_id" name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ Request('category_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-info">
                            <i class="ti ti-search"></i> Search
                        </button>
                    </div>
                </div>
            </form> --}}
            <table class="table mb-3">
                <thead>
                    <th>No.</th>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>#</th>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->invoice_number }}</td>
                            <td>{{ $transaction->customer->customer_name }}</td>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            <td>
                                {{-- <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
