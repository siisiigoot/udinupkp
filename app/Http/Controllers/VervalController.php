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
use File;

class VervalController extends Controller
{
    //
    public function __construct(){
        $this->middleware('checkrole');
    }
    
    public function index(){
        $batas = 500;
        $jumlahdata = Pendaftaran::count();
        $datapendaftaran = Pendaftaran::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($datapendaftaran->currentPage() - 1);
        return view('admin.verval.index',compact('datapendaftaran', 'no', 'jumlahdata'));
    }

    public function view($id){
        $datapendaftaran = Pendaftaran::findOrFail($id);
        $hitung=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','1')->count();
		$hitungsudah=Pemberkasan::where('pendaftaran_id',$id)->where('file','<>',' ')->count();
        $hitungberkas=Pemberkasan::where('pendaftaran_id',$id)->count();
        $no = 0;
		$hitungbelum=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','0')->count();
		// $tolak=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','0')->get();
        $datapemberkasan = DB::table('pemberkasan')
                ->join('pendaftaran', 'pendaftaran.id', '=', 'pemberkasan.pendaftaran_id')
                ->join('dokumen', 'pemberkasan.dokumen_id', '=', 'dokumen.id')
                ->where('pendaftaran.id','=',$id)
                ->select('dokumen.*','pemberkasan.id','pemberkasan.file','pemberkasan.folder','pemberkasan.verifikasi')
                ->orderBy('pemberkasan.dokumen_id','asc')
                ->get();
        $tolak = DB::table('pemberkasan')
                ->join('pendaftaran', 'pendaftaran.id', '=', 'pemberkasan.pendaftaran_id')
                ->join('dokumen', 'pemberkasan.dokumen_id', '=', 'dokumen.id')
                ->where('pendaftaran.id','=',$id)
                ->where('pemberkasan.verifikasi','=',0)
                ->select('dokumen.*','pemberkasan.id','pemberkasan.file','pemberkasan.folder','pemberkasan.verifikasi')
                ->orderBy('pemberkasan.dokumen_id','asc')
                ->get();

        return view('admin.verval.view', compact('hitung','hitungsudah','hitungberkas','datapendaftaran','datapemberkasan','no','hitungbelum','tolak'));
    }

    public function changeStatus(Request $request)
    {
        $change = Pemberkasan::find($request->id);
        $change->verifikasi = $request->verifikasi;
        $change->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function kirim(Request $request){
        $request->validate([
            'subujian' => 'required',
            'pendaftaran' => 'required'
        ]);
        $datapendaftaran = Pendaftaran::findOrFail($request->pendaftaran);
        $id= $request->pendaftaran;
        $hitung=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','1')->count();
        if ($datapendaftaran->subujian->id < 3 and $hitung <> 4) {
            return redirect('/verifikasi/view/'.$id)->with('gagal', 'Tidak dapat diverifikasi. Harap cek kembali.');
        } elseif ($datapendaftaran->subujian->id > 2 and $hitung <> 10) {
            return redirect('/verifikasi/view/'.$id)->with('gagal', 'Tidak dapat diverifikasi. Harap cek kembali.');
        }
        else {
            $kirim=Pendaftaran::find($id);
            $kirim->status = "DISETUJUI";
            $kirim->update();  
            return redirect('/verifikasi/view/'.$id)->with('pesan', 'Usulan telah di setujui.');
        }

        // $id= $request->pendaftaran;
        // $kirim=Pendaftaran::find($id);
        // $kirim->status = "DISETUJUI";
        // $kirim->update();  
        // return redirect('/verifikasi/view/'.$id)->with('pesan', 'Usulan telah di setujui.');
    }

    public function tolak(Request $request){
        $request->validate([
            'inputAlasan' => 'required',
            'pendaftaran' => 'required'
        ]);

        $id= $request->pendaftaran;
        // $hitung=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','1')->count();
        $table = Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','0')->get();
        $tolak = $request->inputAlasan;
        dd($tolak);
        $kirim=Pemberkasan::find(69);
        $kirim->alasan_tolak = "VERIFIKASI";
        $kirim->save(); 
        // return redirect('/verifikasi/view/'.$id)->with('pesan', 'Usulan telah di tolaks.');
        // dd($hasil);
    }

    public function batal(Request $request){
        $request->validate([
            'subujian' => 'required',
            'pendaftaran' => 'required'
        ]);
        $id= $request->pendaftaran;
        $change = DB::table('pemberkasan')->where('pendaftaran_id',$id)->update(['verifikasi'=>0]);
        $kirim=Pendaftaran::find($id);
        $kirim->status = "VERIFIKASI";
        $kirim->save(); 
        return redirect('/verifikasi/view/'.$id)->with('pesan', 'Usulan berhasil dibatalkan.');
    }
    
    public function kembalikan(Request $request){
        $request->validate([
            'subujian' => 'required',
            'pendaftaran' => 'required'
        ]);
        $id= $request->pendaftaran;
        $kirim=Pendaftaran::find($id);
        $kirim->status = "BARU";
        $kirim->update(); 
        return redirect('/verifikasi/view/'.$id)->with('pesan', 'Usulan telah dibatalkan dan dikembalikan kepada fasilitator perangkat daerah.');
    }

    public function destroy(Request $request, $id){
        $hapuspendaftaran = Pendaftaran::find($id);
        $hapuspemberkasan=Pemberkasan::where('pendaftaran_id',$id);

        $hapuspendaftaran -> delete();
        $hapuspemberkasan -> delete();
        $nip = $request->nip;
        File::deleteDirectory(public_path('uploads'.'/'.$nip));
        return redirect('/verifikasi')->with('pesan', 'Data berhasil dihapus. . .');
    }
}