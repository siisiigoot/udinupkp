<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
use App\PerangkatDaerah;
use App\User;

class PegawaiController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        if (auth()->user()->role === 'admin') {
            $batas = 10;
            $jumlahdata = Pegawai::count();
            $dataperangkatdaerah = PerangkatDaerah::all();
            $datapegawai = Pegawai::orderBy('nip', 'desc')->paginate($batas);
            $no = $batas * ($datapegawai->currentPage() - 1);
            return view('admin.pegawai.index',compact('dataperangkatdaerah','datapegawai', 'no', 'jumlahdata'));
        } else {
            $id = auth()->user()->id;
            $namapd = User::find($id);
            $pd = auth()->user()->perangkatdaerah_id;
            $batas = 10;
            $jumlahdata = Pegawai::where('pd_id','=',$pd)->count();
            $dataperangkatdaerah = PerangkatDaerah::all();
            $datapegawai = Pegawai::where('pd_id','=',$pd)->orderBy('nip', 'desc')->paginate($batas);
            $no = $batas * ($datapegawai->currentPage() - 1);
            return view('admin.pegawai.index',compact('namapd','dataperangkatdaerah','datapegawai', 'no', 'jumlahdata'));            
        }

    }
    public function view($id){
        $datapegawai = Pegawai::find($id);
        return view('admin.pegawai.view', compact('datapegawai'));
    }

    public function create(){
        return view('admin.album.create');
    }

    public function store(Request $request){
/*             $this->validate($request,[
            'nama_album'=>'required',
            'gambar'=>'required|image|mimes:jpeg,jpg,png'
        ]);
        $album = New Album;
        $album->nama_album = $request->nama_album;
        $album->album_seo = Str::slug($request->nama_album);

        $gambar = $request->gambar;
        $namafile = time().'.'.$gambar->getClientOriginalExtension();
        $gambar->move('images/', $namafile);

        $album->gambar = $namafile;
        $album->save(); */
        return redirect('/album')->with('pesan', 'Data Album berhasil disimpan');
    }

    public function edit($id){
/*             $album = Album::find($id); */
        return view('admin.album.edit', compact('album'));
    }

    public function update(Request $request, $id){
/*             $album = Album::find($id);
        if ($request->has('gambar')){
            $album->nama_album = $request->nama_album;
            $album->album_seo  = Str::slug($request->nama_album);

            $gambar = $request->gambar;
            $namafile = time().'.'.$gambar->getClientOriginalExtension();
            $gambar->move('images/', $namafile);
            $album->gambar = $namafile;    
        }
        else{
            $album->nama_album = $request->nama_album;
            $album->album_seo = Str::slug($request->nama_album);    
        }

        $album->update(); */
        return redirect('/album')->with('pesan','Data Album berhasil di update');
    }

    public function destroy($id){
/*             $album = Album::find($id);
        $namafile = $album->gambar;
        File::delete('images/'.$namafile);
        $album->delete(); */
        return redirect('/album')->with('pesan', 'Data Album berhasil di hapus');
    }

    public function search(Request $request){

        if (auth()->user()->role === 'admin') {
            $this->validate($request,[
                'kata'=>'required'
            ]);
            $batas = 10;
            $cari = $request->kata;
            $dataperangkatdaerah = PerangkatDaerah::all();
            $datapegawai = Pegawai::where('nama','like',"%".$cari."%")->orwhere('nip','like',"%".$cari."%")->paginate();
            $no = $batas * ($datapegawai->currentPage() - 1);
            return view('admin.pegawai.search', compact('dataperangkatdaerah','datapegawai', 'no', 'cari'));
        } else{
/*             $this->validate($request,[
                'kata'=>'required'
            ]); */
            $pd = auth()->user()->perangkatdaerah_id;
            $batas = 10;
            $cari = $request->kata;
            $dataperangkatdaerah = PerangkatDaerah::all();
            $datapegawai = Pegawai::where('pd_id','=',$pd)->where('nama','like',"%".$cari."%")->orwhere('nip','like',"%".$cari."%")->paginate();
            $no = $batas * ($datapegawai->currentPage() - 1);
            return view('admin.pegawai.search', compact('dataperangkatdaerah','datapegawai', 'no', 'cari')); 
        }
    } 

    public function editjabatan(Request $request){
        $batas = 10;
        $cari = $request->kata;
        $datapegawai = Pegawai::where('nama','like',"%".$cari."%")->orwhere('nip','like',"%".$cari."%")->paginate();
        $no = $batas * ($datapegawai->currentPage() - 1);
        return view('admin.pegawai.editjabatan', compact('datapegawai', 'no', 'cari'));    
    }
}
