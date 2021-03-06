<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Lokasi;

class InfolokasiController extends Controller
{
    //
    function Datalokasi(){
        // mengambil data dari table tb_penyakit
    	$datalokasi = DB::table('tb_lokasi')->get();
 
    	// mengirim data penyakit ke view datapenyakit
    	return view('/lokasi/datalokasi',['datalokasi' => $datalokasi]);
    }

    function viewtambahlokasi(){
        $datawarga = DB::table('tb_warga as w')->get();

        // memanggil view tambahpenyakit
        return view('/lokasi/tambahlokasi' , ['datawarga' => $datawarga]);
    }

    function tambahlokasi(Request $request){
        $add = new Lokasi;
        $add->no_kk = $request->input('no_kk');
        $add->latitude = $request->input('latitude');
        $add->longitude = $request->input('longitude');
        $add->save();
        
        return response()->json(array('status' => 'success', 'reason' => 'Sukses Tambah Data'));
    }

    // method untuk edit data penyakit
public function editlokasi($id_lokasi)
{
	// mengambil data penyakit berdasarkan id yang dipilih
	$lokasi = DB::table('tb_lokasi')->where('id_lokasi',$id_lokasi)->get();
	// passing data penyakit yang didapat ke view edit.blade.php
	return view('/lokasi/editlokasi',['datalokasi' => $lokasi]);

}

// update data penyakit
public function updatelokasi(Request $request)
{
	// update data penyakit
	DB::table('tb_lokasi')->where('id_lokasi',$request->id_lokasi)->update([
        'no_kk' => $request->no_kk,
        'latitude' => $request->latitude,
		'longitude' => $request->longitude,
	]);

    return response()->json(array('status'=> 'success', 'reason' => 'Sukses Edit Data'));
    
}

public function deletelokasi($id_lokasi)
{
	// menghapus data penyakit berdasarkan id yang dipilih
	DB::table('tb_lokasi')->where('id_lokasi',$id_lokasi)->delete();
		
	return response()->json(array('status'=> 'success', 'reason' => 'Sukses Hapus Data'));
}

public function getlokasi(Request $request)
{
	// menghapus data warga berdasarkan id yang dipilih
	// Warga::where('nik',$request->input('nik'))->first();
	$getwarga = DB::table('tb_warga as w')->where('nik',$request->input('nik'))
	->join('tb_lokasi as l', 'l.no_kk','=', 'w.no_kk')
	->first();
		
	return response()->json($getlokasi);
}

}
