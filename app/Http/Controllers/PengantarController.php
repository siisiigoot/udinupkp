<?php

namespace App\Http\Controllers;
Use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Pengantar;
use App\Pendaftaran;
use File;

class PengantarController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(Request $request){

        $pd = auth()->user()->perangkatdaerah_id;
        $datapengantar = Pengantar::where('pd_id','=',$pd)->get();
        $jumlahpengantar = Pengantar::where('pd_id','=',$pd)->count();
        $batas = 10;
        $jumlahdata = Pengantar::count();
/*         $hitungusulan = Pendaftaran::where('pengantar_id','<>',$id)->count();  */
/*         $datapendaftaran = Pendaftaran::with('pegawai')->get(); */
/*         $datapendaftaran = Pendaftaran::orderBy('id', 'desc')->paginate($batas); */
        $no = 0;
        return view('fasil.pengantar.index',compact('jumlahpengantar','no','jumlahdata','datapengantar'));
    }

    public function view($id){

        $no = 0;
        $pd = auth()->user()->perangkatdaerah_id;
        $datapengantar = Pengantar::where('pd_id',$pd)->findorfail($id);
        $datapendaftaran = DB::table('pendaftaran')
            ->leftjoin('pengantar', 'pendaftaran.pengantar_id', '=', 'pengantar.id')
            ->leftjoin('pegawai', 'pendaftaran.pegawai_id', '=', 'pegawai.id')
            ->join('subujian', 'pendaftaran.subujian_id', '=', 'subujian.id')
            ->where('pengantar.id','=',$id)
            ->where('pegawai.pd_id','=',$pd)
            ->select(
                'pengantar.id as pengatarid','pengantar.nomor','pengantar.tanggal','pengantar.file',
                'pendaftaran.status','pendaftaran.nomor_peserta','pendaftaran.periode','pendaftaran.id',
                'pegawai.id as pegid','pegawai.nip','pegawai.nama',
                'pegawai.gol','pegawai.jab','pegawai.unkerja','pegawai.pd',
                'pegawai.instansi','pegawai.ting_pend','subujian.nama_subujian')
            ->get();

/*         $datapengantar = DB::table('pengantar')
            ->leftjoin('pendaftaran', 'pengantar.id', '=', 'pendaftaran.pengantar_id')
            ->where('pengantar.id','=',$id)
            ->select('pengantar.*')
            ->groupBy('pengantar.id')
            ->get()
            ->first(); */


        return view('fasil.pengantar.view', compact('datapengantar','datapendaftaran','no'));
    }

    public function create(Request $request){
/*         $dataujian = Pendaftaran::all();
        $jumlahujian = Pendaftaran::count();
        $last = Pendaftaran::latest()->first();
        $datasubujian = SubUjian::get()->groupBy('ujian_id'); */
        return view('fasil.pengantar.create'/* ,compact('last','dataujian','jumlahujian','datasubujian') */)->with('pesan', 'Data ditemukan, silahkan pilih jenis ujian..');
    }

    public function edit(Request $request, $id){
        $datapengantar = Pengantar::find($id);
        return view('fasil.pengantar.edit',compact('datapengantar'))->with('pesan', 'Data ditemukan, silahkan pilih jenis ujian..');
    }

    public function update(Request $request){
        $request->validate([
            'no_surat' => 'required',
            'tgl_surat' => 'required',
            'perihal' => 'required',
/*             'file' => 'required|mimes:pdf|max:2048' */
        ]);


        $id=$request->pengantarid;
        $datapengantar = Pengantar::find($id);

        if ($request->has('file')){
            $namadok = Str::slug($request->no_surat);
            $input = $request->all();
            $file = $request->file('file');
            $input['file'] = $namadok.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/pengantar'),$input['file']);
            $datapengantar -> nomor = $request -> no_surat;
            $datapengantar -> tanggal = $request -> tgl_surat;
            $datapengantar -> perihal = $request -> perihal;
            $datapengantar -> file = $input['file'];
            $datapengantar -> pd_id = auth()->user()->perangkatdaerah_id; 
        }
        else{
            $datapengantar -> nomor = $request -> no_surat;
            $datapengantar -> tanggal = $request -> tgl_surat;
            $datapengantar -> perihal = $request -> perihal; 
            $datapengantar -> pd_id = auth()->user()->perangkatdaerah_id;  
        }
        
        $datapengantar -> update();
        return redirect('/pengantar')->with('pesan', 'Surat pengantar telah di ubah...');
    }

    public function store(Request $request){
        $request->validate([
            'no_surat' => 'required',
            'tgl_surat' => 'required',
            'perihal' => 'required',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $namadok = Str::slug($request->no_surat);
        $input = $request->all();
        $file = $request->file('file');
        $input['file'] = $namadok.'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/pengantar'),$input['file']);
        
        $datapengantar = New Pengantar;
        $datapengantar -> nomor = $request -> no_surat;
        $datapengantar -> tanggal = $request -> tgl_surat;
        $datapengantar -> perihal = $request -> perihal;
        $datapengantar -> file = $input['file'];
        $datapengantar -> pd_id = auth()->user()->perangkatdaerah_id;
        $datapengantar -> save();
        return redirect('/pengantar')->with('pesan', 'Surat pengantar telah ditambahkan...');
    }

    public function destroy(Request $request, $id){
        $pd = auth()->user()->perangkatdaerah_id;
        $datapendaftaran = DB::table('pendaftaran')
        ->leftjoin('pengantar', 'pendaftaran.pengantar_id', '=', 'pengantar.id')
        ->leftjoin('pegawai', 'pendaftaran.pegawai_id', '=', 'pegawai.id')
        ->join('subujian', 'pendaftaran.subujian_id', '=', 'subujian.id')
        ->where('pengantar.id','=',$id)
        ->where('pegawai.pd_id','=',$pd)
        ->select(
            'pengantar.id','pengantar.nomor','pengantar.tanggal','pengantar.file',
            'pendaftaran.status','pendaftaran.nomor_peserta','pendaftaran.periode',
            'pegawai.id as pegid','pegawai.nip','pegawai.nama',
            'pegawai.gol','pegawai.jab','pegawai.unkerja','pegawai.pd',
            'pegawai.instansi','pegawai.ting_pend','subujian.nama_subujian')
        ->count();

        if ($datapendaftaran === 0) {
            $hapuspengantar = Pengantar::find($id);
    /*         $hapuspemberkasan=Pemberkasan::where('pendaftaran_id',$id); */
    
            $hapuspengantar -> delete();
    /*         $hapuspemberkasan -> delete(); */
            $file = $request->file;
            File::delete(public_path('uploads/pengantar/'.$file));
            return redirect('/pengantar')->with('pesan', 'Surat pengantar telah dihapus. . .');
            
        } else {

            return redirect('/pengantar')->with('gagal', 'Surat pengantar tidak dapat dihapus, karena terdapat pegawai yang sedang dalam proses usulan di usulkan. . .');
        }
    }

    public function kirim(Request $request){
/*         $request->validate([
            'pengantar' => 'required',
            'subujian' => 'required',
            'pendaftaran' => 'required'
        ]);
        $id= $request->pendaftaran;
        $kirim=Pendaftaran::find($id);
        $kirim->status = "BARU";
        $kirim->pengantar_id = $request->pengantar;
        $kirim->update();  
        return redirect('/pendaftaran')->with('pesan', 'Usulan telah ditambahkan...');   */

        $request->validate([
            'id' => 'required'
        ]);
        $id="halo";
        echo $id;      
    }
}
