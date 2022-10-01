<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ujian;
use App\SubUjian;

class SubUjianController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $batas = 10;
        $jumlahdata = SubUjian::count();
        $datasubujian = SubUjian::orderBy('id', 'desc')->paginate($batas);
        $dataujian = Ujian::all();
        $jumlahujian = Ujian::count();
        $no = $batas * ($datasubujian->currentPage() - 1);
        return view('admin.pengaturan.sub_ujian.index',compact('datasubujian', 'no', 'jumlahdata','dataujian','jumlahujian'));
    }
    public function view($id){
        $datasubujian = SubUjian::find($id);
        return view('admin.pengaturan.sub_ujian.view', compact('datasubujian'));
    }

    public function create(){
        $dataujian = Ujian::all();
        $jumlahujian = Ujian::count();
        return view('admin.pengaturan.sub_ujian.create',compact('dataujian','jumlahujian'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'ujian'=>'required',
            'nama_subujian'=>'required',
            'ket'=>'required'
        ]);
        $datasubujian = New SubUjian;
        $datasubujian -> nama_subujian = $request -> nama_subujian;
        $datasubujian -> ket = $request -> ket;
        $datasubujian -> ujian_id = $request -> ujian;
        $datasubujian -> save();
        return redirect('/sub-ujian')->with('pesan', 'Data berhasil ditambahkan...');
    }

    public function edit($id){
        $dataujian = Ujian::all();
        $datasubujian = SubUjian::find($id);
        return view('admin.pengaturan.sub_ujian.edit', compact('datasubujian','dataujian'));
    }

    public function update(Request $request, $id){
        $datasubujian = SubUjian::find($id);
        $datasubujian -> nama_subujian = $request -> nama_subujian;
        $datasubujian -> ket = $request -> ket;
        $datasubujian -> ujian_id = $request -> ujian;
        $datasubujian -> update();
        return redirect('/sub-ujian')->with('pesan','Data berhasil diubah. . .');
    }

    public function destroy($id){
        $datasubujian = SubUjian::find($id);
        $datasubujian -> delete();
        return redirect('/sub-ujian')->with('pesan', 'Data berhasil dihapus. . .');
    }

    public function search(Request $request){
        $batas = 10;
        $cari = $request->kata;
        $datapegawai = Pegawai::where('nama','like',"%".$cari."%")->orwhere('nip','like',"%".$cari."%")->paginate();
        $no = $batas * ($datapegawai->currentPage() - 1);
        return view('admin.pengaturan.sub_ujian.search', compact('datapegawai', 'no', 'cari'));    
    }
}
