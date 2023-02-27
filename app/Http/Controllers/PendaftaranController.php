<?php

namespace App\Http\Controllers;

Use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Pendaftaran;
use App\Pegawai;
use App\SubUjian;
use App\Pemberkasan;
use App\Pengantar;
use App\User;
use File;

class PendaftaranController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){        
        $pd = auth()->user()->perangkatdaerah_id;
        $datapendaftaran = DB::table('pendaftaran')
            ->join('pegawai', 'pendaftaran.pegawai_id', '=', 'pegawai.id')
            ->join('perangkatdaerah', 'pegawai.pd_id', '=', 'perangkatdaerah.id')
            ->join('subujian', 'subujian.id', '=', 'pendaftaran.subujian_id')
            ->where('pegawai.pd_id','=',$pd)
            ->select('pendaftaran.id',
                'pendaftaran.status',
                'pendaftaran.nomor_peserta',
                'pendaftaran.periode',
                'pegawai.id as pegid',
                'pegawai.nip',
                'pegawai.nama',
                'pegawai.gol',
                'pegawai.jab',
                'pegawai.unkerja',
                'pegawai.pd',
                'pegawai.instansi',
                'pegawai.ting_pend',
                'subujian.nama_subujian')
            ->get();
        $batas = 10;
        $jumlahdata = Pendaftaran::count();
/*         $datapendaftaran = Pendaftaran::with('pegawai')->get(); */
/*         $datapendaftaran = Pendaftaran::orderBy('id', 'desc')->paginate($batas); */
        $no = 0;
        return view('fasil.pendaftaran.index',compact('datapendaftaran', 'no', 'jumlahdata'));
    }

    public function view($id){
        $pd = auth()->user()->perangkatdaerah_id;;
        $datapengantar = Pengantar::where('pd_id','=',$pd)->get();
        $jumlahpengantar = Pengantar::where('pd_id','=',$pd)->count();
        $datapendaftaran = Pendaftaran::findOrFail($id);
        $hitung=Pemberkasan::where('pendaftaran_id',$id)->where('file',' ')->count();
        $hitungsudah=Pemberkasan::where('pendaftaran_id',$id)->where('file','<>',' ')->count();
        $hitungberkas=Pemberkasan::where('pendaftaran_id',$id)->count();
        $no = 0;
        $datapemberkasan = DB::table('pemberkasan')
                ->join('pendaftaran', 'pendaftaran.id', '=', 'pemberkasan.pendaftaran_id')
                ->join('dokumen', 'pemberkasan.dokumen_id', '=', 'dokumen.id')
                ->where('pendaftaran.id','=',$id)
                ->select('dokumen.*','pemberkasan.id','pemberkasan.file','pemberkasan.folder','pemberkasan.verifikasi','pemberkasan.alasan_tolak','pemberkasan.dokumen_id')
                ->orderBy('pemberkasan.dokumen_id','asc')
                ->get();
/*         $nosurat = DB::table('pengantar')
                ->join('pendaftaran',' pendaftaran.pengantar_id', '=', 'pengantar.id')
                ->where('pendaftaran.id','=',$id)
                ->select('pengantar.*','pendaftaran.*')
                ->get(); */
        $nosurat=Pendaftaran::find($id);

        return view('fasil.pendaftaran.view', compact('nosurat','datapengantar','jumlahpengantar','hitungberkas','hitungsudah','hitung','datapendaftaran','datapemberkasan','no'));
    }
    
    public function create(Request $request){
        $dataujian = Pendaftaran::all();
        $jumlahujian = Pendaftaran::count();
/*         $last = Pendaftaran::latest()->firstorfail(); */
        $datasubujian = SubUjian::get()->groupBy('ujian_id');
        return view('fasil.pendaftaran.create',compact('dataujian','jumlahujian','datasubujian'))->with('pesan', 'Data ditemukan, silahkan pilih jenis ujian..');
    }
    
    public function search(Request $request){
        $this->validate($request,[
            'nip'=>'required'
        ]);
        $pd = auth()->user()->perangkatdaerah_id;
        $cari=$request->nip;
        $last = Pendaftaran::latest()->first();
        $datasubujian = SubUjian::get()->groupBy('ujian_id');
        if ($datapegawai = Pegawai::where([
            ['nip', '=', $cari],
            ['pd_id', '=', $pd],
        ])->first())
        {
/*             return view('fasil.pendaftaran.search', compact('last','datapegawai','datasubujian'))->with('pesan', 'Data tidak ditemukan...');  */   
        return view('fasil.pendaftaran.search', compact('last','datapegawai','datasubujian'))->with('pesan', 'Data tidak ditemukan...');
        } else {
            return redirect('/pendaftaran/create')->with('pesan', 'Data tidak ditemukan, cek kembali data pegawai yang dicari...');
        }
    }

    public function store(Request $request){
        $this->validate($request,[
            'jenis_ujian'=>'required',
            'periode'=>'required',
            'pegawai_id'=>'required|unique:pendaftaran'
        ]); 
        $datapendaftaran = New Pendaftaran();
        $datapendaftaran -> pegawai_id = $request -> pegawai_id;
        $datapendaftaran -> nomor_peserta = " ";
        $datapendaftaran -> periode = $request -> periode;
        $datapendaftaran -> status = "BARU";
        $datapendaftaran -> subujian_id = $request -> jenis_ujian;
        $datapendaftaran -> save();

        $last = Pendaftaran::latest()->first();
        $sub = $request -> jenis_ujian;
        $datasub = SubUjian::find($sub);

        $udin = array (
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>1),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>2),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>3),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>4),
        );
        $upkp = array (
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>5),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>6),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>7),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>8),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>9),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>10),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>11),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>12),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>13),
            array('folder'=>' ', 'file'=>' ', 'verifikasi'=>'0', 'pendaftaran_id'=>$last->id, 'dokumen_id'=>14),
        );

        if ($datasub->id <3 ) {
            $datapemberkasan = Pemberkasan::insert($udin);
        } else {
            $datapemberkasan = Pemberkasan::insert($upkp);
        }

        return redirect('/pendaftaran')->with('pesan', 'Berhasil diusulkan, langkah selanjutnya harap lengkapi dokumen.');
    }

    public function destroy(Request $request, $id){
        $hapuspendaftaran = Pendaftaran::find($id);
        $hapuspemberkasan=Pemberkasan::where('pendaftaran_id',$id);

        $hapuspendaftaran -> delete();
        $hapuspemberkasan -> delete();
        $nip = $request->nip;
        File::deleteDirectory(public_path('uploads'.'/'.$nip));
        return redirect('/pendaftaran')->with('pesan', 'Data berhasil dihapus. . .');
    }

    public function upload(Request $request){
        if ($request->has('foto')){
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,jpg,png'
            ]);
            $nip = $request->nip;
            $namadok = Str::slug($request->namadok);
            $input = $request->all();
            $file = $request->file('foto');
            $input['file'] = $nip.'-'.$namadok.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'.'/'.$nip),$input['file']);
    
            $id=$request->pemberkasanid;
            $simpanberkas = Pemberkasan::find($id);
            $simpanberkas->folder = $nip;
            $simpanberkas->file = $input['file'];
            $simpanberkas->update();        
    
            return redirect()->back()->with('success', 'Dokumen berhasil diunggah...');           
        } else {
            $request->validate([
                'file' => 'required|mimes:pdf|max:2048'
            ]);
            $nip = $request->nip;
            $namadok = Str::slug($request->namadok);
            $input = $request->all();
            $file = $request->file('file');
            $input['file'] = $nip.'-'.$namadok.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'.'/'.$nip),$input['file']);
    
            $id=$request->pemberkasanid;
            $simpanberkas = Pemberkasan::find($id);
            $simpanberkas->folder = $nip;
            $simpanberkas->file = $input['file'];
            $simpanberkas->update();        
    
            return redirect()->back()->with('success', 'Dokumen berhasil diunggah...');
        }

    }

    public function kirim(Request $request){
        $request->validate([
            'pengantar' => 'required',
            'subujian' => 'required',
            'pendaftaran' => 'required'
        ]);
        $id= $request->pendaftaran;
        $kirim=Pendaftaran::find($id);
        $kirim->status = "VERIFIKASI";
        $kirim->pengantar_id = $request->pengantar;
        $kirim->update();  
        return redirect('/pendaftaran')->with('pesan', 'Usulan telah ditambahkan...');        
    }

    public function getDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/uploads/198208202008011004/198208202008011004-skp.pdf";
    
        $headers = array(
                  'Content-Type: application/pdf',
                );
    
        return Response::download($file, 'filename.pdf', $headers);
    }

}
