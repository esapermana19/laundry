<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();
        if($request->service_name) {
            $query->where('service_name', 'like', '%' . $request->service_name . '%');
        }
        if($request->unit) {
            $query->where('unit', $request->unit);
        }
        $service = $query->paginate(4);
        return view('services.index', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_code' => 'required|max:6|unique:services,service_code',
            'service_name' => 'required',
            'unit' => 'required',
            'delivery_type' => 'required',
            'price_per_unit' => 'required|numeric|min:0'
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $request->validate([
            'service_code' => 'required|max:6|unique:services,service_code,' . $service->id,
            'service_name' => 'required',
            'unit' => 'required',
            'delivery_type' => 'required',
            'price_per_unit' => 'required|numeric|min:0'
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
