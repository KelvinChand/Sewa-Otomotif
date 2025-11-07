<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Illuminate\Http\Request;
use App\Models\Kendaraan;

class SewaController extends Controller
{
    //
    public function index(){
        return view('dashboard.index');
    }

    public function getData()
    {
        return datatables()->of(
            Sewa::with('kendaraan')
        )
            ->addColumn('nomor_kendaraan', function ($sewa) {
                return $sewa->kendaraan ? $sewa->kendaraan->nomor_kendaraan : '-';
            })
            ->make(true);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nama_customer' => 'required|string',
            'id_kendaraans' => 'required',
            'tanggal_mulai_sewa'=> 'required',
            'tanggal_berakhir_sewa'=> 'date',
            'harga_sewa' => 'required|numeric',
        ]);

        Sewa::create($validated);
        return response()->json(['success'=>'true']);
    }

    public function show($id)
    {
        $sewa = Sewa::with('kendaraan')->findOrFail($id);

        return response()->json([
            'id_sewas' => $sewa->id_sewas,
            'nama_customer' => $sewa->nama_customer,
            'id_kendaraans' => $sewa->id_kendaraans,
            'tanggal_mulai_sewa' => $sewa->tanggal_mulai_sewa,
            'tanggal_berakhir_sewa' => $sewa->tanggal_berakhir_sewa,
            'harga_sewa' => $sewa->harga_sewa,
            'nomor_kendaraan' => $sewa->kendaraan ? $sewa->kendaraan->nomor_kendaraan : '-',
        ]);
    }

    public function update(Request $request, $id){
        $sewa = Sewa::findOrFail($id);
        $sewa->update($request->all());

        return response()->json(['success'=>'true']);
    }

    public function destroy($id)
    {
        Sewa::destroy($id);
        return response()->json(['success' => true]);
    }
}
