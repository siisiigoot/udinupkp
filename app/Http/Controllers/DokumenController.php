<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dokumen;
use App\Ujian;

class DokumenController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $batas = 10;
        $jumlahdata = Dokumen::count();
        $datadokumen = Dokumen::orderBy('id', 'asc')->paginate($batas);
        $dataujian = Ujian::all();
        $jumlahujian = Ujian::count();
        $no = $batas * ($datadokumen->currentPage() - 1);
        return view('admin.pengaturan.dokumen.index',compact('datadokumen', 'no', 'jumlahdata','dataujian','jumlahujian'));
    }
    public function view($id){
        $datadokumen = Dokumen::find($id);
        return view('admin.pengaturan.dokumen.view', compact('datadokumen'));
    }

    public function create(){
        $dataujian = Ujian::all();
        $jumlahujian = Ujian::count();
        return view('admin.pengaturan.dokumen.create',compact('dataujian','jumlahujian'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'ujian'=>'required',
            'nama_dokumen'=>'required',
            'ket'=>'required'
        ]);
        $datadokumen = New Dokumen();
        $datadokumen -> nama_dokumen = $request -> nama_dokumen;
        $datadokumen -> ket = $request -> ket;
        $datadokumen -> ujian_id = $request -> ujian;
        $datadokumen -> save();
        return redirect('/dokumen')->with('pesan', 'Data berhasil ditambahkan...');
    }

    public function edit($id){
        $dataujian = Ujian::all();
        $datadokumen = Dokumen::find($id);
        return view('admin.pengaturan.dokumen.edit', compact('datadokumen','dataujian'));
    }

    public function update(Request $request, $id){
        $datadokumen = Dokumen::find($id);
        $datadokumen -> nama_dokumen = $request -> nama_dokumen;
        $datadokumen -> ket = $request -> ket;
        $datadokumen -> ujian_id = $request -> ujian;
        $datadokumen -> update();
        return redirect('/dokumen')->with('pesan','Data berhasil diubah. . .');
    }

    public function destroy($id){
        $datadokumen = Dokumen::find($id);
        $datadokumen -> delete();
        return redirect('/dokumen')->with('pesan', 'Data berhasil dihapus. . .');
    }

    public function search(Request $request){
        $batas = 10;
        $cari = $request->kata;
        $datapegawai = Pegawai::where('nama','like',"%".$cari."%")->orwhere('nip','like',"%".$cari."%")->paginate();
        $no = $batas * ($datapegawai->currentPage() - 1);
        return view('admin.pengaturan.dokumen.search', compact('datapegawai', 'no', 'cari'));    
    }
}
