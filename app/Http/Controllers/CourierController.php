<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // pagination.
        $courierPage = Courier::paginate(10);
        // urutkan berdasarkan nama kurir
        $courier_name = Courier::orderBy('nama_depan', 'asc')->get();
        // urutkan berdasarkan tanggal didaftarkan
        $courier_date = Courier::orderBy('created_at', 'desc')->get();
        //  mencari kurir
        if (request('search_courier')) {
            $search_courier = Courier::where('nama_depan', 'like', '%' . request('search_courier') . '%')
                ->orWhere('nama_belakang', 'like', '%' . request('search_courier') . '%')
                ->get();
        }
        // hanya kurir yang memiliki level 2 atau 3 saja (?level=2,3).
        $courier_level = Courier::whereIn('level', [2, 3])->get();

        return view('couriers.index', compact('courier_date', 'search_courier', 'courier_level'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            if (!$request->has(['nama_depan', 'nama_belakang', 'no_telp', 'email', 'alamat_domisili', 'status', 'level'])) {
                return redirect()->back()->with('error', 'Data kurir tidak lengkap.');
            }
            $courier = new Courier();
            $courier->nama_depan = $request->nama_depan;
            $courier->nama_belakang = $request->nama_belakang;
            $courier->no_telp = $request->no_telp;
            $courier->email = $request->email;
            $courier->alamat_domisili = $request->alamat_domisili;
            $courier->status = $request->status;
            $courier->level = $request->level;
            $courier->save();

            return redirect()->back()->with('success', 'Kurir berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan kurir: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        //
        $data = $courier;
        return view('couriers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        //
        try {
            if (!$request->has(['nama_depan', 'nama_belakang', 'no_telp', 'email', 'alamat_domisili', 'status', 'level'])) {
                return redirect()->back()->with('error', 'Data kurir tidak lengkap.');
            }
            $courier->nama_depan = $request->nama_depan;
            $courier->nama_belakang = $request->nama_belakang;
            $courier->no_telp = $request->no_telp;
            $courier->email = $request->email;
            $courier->alamat_domisili = $request->alamat_domisili;
            $courier->status = $request->status;
            $courier->level = $request->level;
            $courier->save();

            return redirect()->back()->with('success', 'Kurir berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui kurir: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        //
        try {
            $courier->delete();
            return redirect()->back()->with('success', 'Kurir berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus kurir: ' . $e->getMessage());
        }
    }
}
