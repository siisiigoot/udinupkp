<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ujian;

class UjianController extends Controller
{
    //
    public function __construct(){
        $this->middleware('checkrole');
    }
    
    public function index(){
        $batas = 10;
        $jumlahdata = Ujian::count();
        $dataujian = Ujian::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($dataujian->currentPage() - 1);
        return view('admin.pengaturan.ujian.index',compact('dataujian', 'no', 'jumlahdata'));
    }
    public function view($id){
        $dataujian = Ujian::find($id);
        return view('admin.pengaturan.ujian.view', compact('dataujian'));
    }

    public function create(){
        return view('admin.pengaturan.ujian.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'nama_ujian'=>'required',
            'ket'=>'required'
        ]);
        $dataujian = New Ujian;
        $dataujian -> nama_ujian = $request -> nama_ujian;
        $dataujian -> ket = $request -> ket;
        $dataujian -> save();
        return redirect('/ujian')->with('pesan', 'Data berhasil ditambahkan...');
    }

    public function edit($id){
        $dataujian = Ujian::find($id);
        return view('admin.pengaturan.ujian.edit', compact('dataujian'));
    }

    public function update(Request $request, $id){
        $dataujian = Ujian::find($id);
        $dataujian -> nama_ujian = $request -> nama_ujian;
        $dataujian -> ket = $request -> ket;
        $dataujian -> update();
        return redirect('/ujian')->with('pesan','Data berhasil diubah. . .');
    }

    public function destroy($id){
        $dataujian = Ujian::find($id);
        $dataujian -> delete();
        return redirect('/ujian')->with('pesan', 'Data berhasil dihapus. . .');
    }

    public function search(Request $request){
        $batas = 10;
        $cari = $request->kata;
        $datapegawai = Pegawai::where('nama','like',"%".$cari."%")->orwhere('nip','like',"%".$cari."%")->paginate();
        $no = $batas * ($datapegawai->currentPage() - 1);
        return view('admin.pengaturan.ujian.search', compact('datapegawai', 'no', 'cari'));    
    }
}
