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
use Yajra\Datatables\Datatables;

class VervalController extends Controller
{
    
    public function __construct(){
        $this->middleware('checkrole');
    }
    
    public function index(){

        $data['periodes'] = Pendaftaran::distinct()->get(['periode']);
        $data1['statuses'] = Pendaftaran::distinct()->get(['status']);
  
        return view('admin.verval.index',$data,$data1);
     }

   // Fetch DataTable data
   public function getPendaftaran(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    // Custom search filter 
    $searchPeriode = $request->get('searchPeriode');
    $searchStatus = $request->get('searchStatus');
    $searchSubUjian = $request->get('searchSubUjian');

    // Total records
    $records = Pendaftaran::select('count(*) as allcount');

    ## Add custom filter conditions
    if(!empty($searchPeriode)){
        $records->where('periode',$searchPeriode);
    }
    if(!empty($searchStatus)){
        $records->where('status',$searchStatus);
    }
    if(!empty($searchSubUjian)){
        $records->where('subujian_id','like','%'.$searchSubUjian.'%');
    }
    $totalRecords = $records->count();

    // Total records with filter
    $records = Pendaftaran::select('count(*) as allcount')->where('subujian_id', 'like', '%' .$searchValue . '%');

    ## Add custom filter conditions
    if(!empty($searchPeriode)){
        $records->where('periode',$searchPeriode);
    }
    if(!empty($searchStatus)){
        $records->where('status',$searchStatus);
    }
    if(!empty($searchSubUjian)){
        $records->where('subujian_id','like','%'.$searchSubUjian.'%');
    }
    $totalRecordswithFilter = $records->count();

    // Fetch records
    $records = Pendaftaran::orderBy($columnName,$columnSortOrder)
            ->join('pegawai', 'pendaftaran.pegawai_id', '=', 'pegawai.id')
            ->join('subujian', 'pendaftaran.subujian_id', '=', 'subujian.id')
            ->select(
            'pendaftaran.id',
            'subujian.nama_subujian as namasubujian',
            'pendaftaran.periode',
            'pendaftaran.status',
            'pegawai.nama as namapeg',
            'pegawai.pd as namapd'
            )
            ->where('subujian_id', 'like', '%' .$searchValue . '%');
    ## Add custom filter conditions
    if(!empty($searchPeriode)){
        $records->where('periode',$searchPeriode);
    }
    if(!empty($searchStatus)){
        $records->where('status',$searchStatus);
    }
    if(!empty($searchSubUjian)){
        $records->where('subujian_id','like','%'.$searchSubUjian.'%');
    }
    $pendaftarans = $records->skip($start)
                ->take($rowperpage)
                ->get();

    $data_arr = array();
    foreach($pendaftarans as $pendaftaran){
        
        $id = $pendaftaran->id;
        $namasubujian = $pendaftaran->namasubujian;
        $periode = $pendaftaran->periode;
        $status = $pendaftaran->status;
        $namapd = $pendaftaran->namapd;
        $namapeg = $pendaftaran->namapeg;
        $action =
        '<a href="' . route('verifikasi.view', $id) . '" class="btn btn-secondary btn-sm btn-icon icon-left"><i class="fas fa-search"></i></a>'
        ;

        $data_arr[] = array(
            "periode" => $periode,
            "id" => $id,
            "namasubujian" => $namasubujian,
            "status" => $status,
            "namapd" => $namapd,
            "namapeg" => $namapeg,
            "action" => $action,
        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    return response()->json($response); 
 }


    // public function index(Request $request)
    // {
    //     $periode = $request->input('periode');
    //     $status = $request->input('status');
    
    //     $pendaftaran = DB::table('pendaftaran')
    //                 ->when($periode, function ($query, $periode) {
    //                     return $query->where('periode', $periode);
    //                 })
    //                 ->when($status, function ($query, $status) {
    //                     return $query->where('status', $status);
    //                 })
    //                 ->get();
    
    //     return view('admin.verval.index', compact('pendaftaran'));
    // }
    
    // public function data()
    // {
    //     $pendaftaran = Pendaftaran::select('*');

    //     return DataTables::of($pendaftaran)->make(true);
    // }
    

    // public function index(){
    //     $batas = 500;
    //     $jumlahdata = Pendaftaran::count();
    //     $datapendaftaran = Pendaftaran::orderBy('id', 'desc')->paginate($batas);
    //     $no = $batas * ($datapendaftaran->currentPage() - 1);
    //     return view('admin.verval.index',compact('datapendaftaran', 'no', 'jumlahdata'));
    // }

    public function view($id){
        $datapendaftaran = Pendaftaran::findOrFail($id);
        $hitung=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','1')->count();
		$hitungsudah=Pemberkasan::where('pendaftaran_id',$id)->where('file','<>',' ')->count();
        $hitungberkas=Pemberkasan::where('pendaftaran_id',$id)->count();
        $hitungxxx=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','0')->count();
        $hitungtolak=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','2')->count();
        $no = 0;
        $urut=0;
		$hitungbelum=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','0')->count();
		// $tolak=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi','0')->get();
        $datapemberkasan = DB::table('pemberkasan')
                ->join('pendaftaran', 'pendaftaran.id', '=', 'pemberkasan.pendaftaran_id')
                ->join('dokumen', 'pemberkasan.dokumen_id', '=', 'dokumen.id')
                ->where('pendaftaran.id','=',$id,'and','pemberkasan.verifikasi','=',2)
                ->select('dokumen.*','pendaftaran.status','pemberkasan.id','pemberkasan.file','pemberkasan.folder','pemberkasan.verifikasi', 'pemberkasan.alasan_tolak')
                ->orderBy('pemberkasan.dokumen_id','asc')
                ->get();
        $tolak = DB::table('pemberkasan')
                ->join('pendaftaran', 'pendaftaran.id', '=', 'pemberkasan.pendaftaran_id')
                ->join('dokumen', 'pemberkasan.dokumen_id', '=', 'dokumen.id')
                ->where('pendaftaran.id','=',$id)
                // ->where('pemberkasan.verifikasi','=',2)
                ->select('dokumen.*','pemberkasan.id','pemberkasan.file','pemberkasan.folder','pemberkasan.verifikasi','pemberkasan.alasan_tolak')
                ->orderBy('pemberkasan.dokumen_id','asc')
                ->get();

        return view('admin.verval.view', compact('hitung','hitungsudah','hitungberkas','datapendaftaran','datapemberkasan','no','urut','hitungbelum','tolak','hitungxxx','hitungtolak'));
    }

    public function changeStatus(Request $request)
    {
        $change = Pemberkasan::find($request->id);
        $change->verifikasi = $request->verifikasi;
        $change->alasan_tolak = $request->alasan;
        $change->save();

        // $berkas = Pemberkasan::wherePendaftaranId($change->pendaftaran_id)->get();

        // $tolak = 0;
        // $verifikasi = 0;
        // $setuju = 0;

        // foreach ($berkas as $key => $value) {
        //     if($value->verifikasi == 0) {
        //         $verifikasi++;
        //     } else if($value->verifikasi == 2) {
        //         $tolak++;
        //     } else {
        //         $setuju++;
        //     }
        // }
        
        // $pendaftaran = Pendaftaran::find($change->pendaftaran_id);

        // if ($setuju == 4) {
        //     $pendaftaran->status == "DISETUJUI";
        // } else if ($tolak >= 1) {
        //     $pendaftaran->status == "DITOLAK";
        // } else {
        //     $pendaftaran->status == "VERIFIKASI";
        // }

        // $pendaftaran->save();
        // dd($berkas);
  
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function proses(Request $request){
        $request->validate([
            'pendaftaran' => 'required'
        ]);
        $id= $request->pendaftaran;
        $hitungtolak=Pemberkasan::where('pendaftaran_id',$id)->where('verifikasi', 2)->count();
        if ($hitungtolak <> 0){
            $kirim=Pendaftaran::find($id);
            $kirim->status = "DITOLAK";
            $kirim->update();  
            return redirect('/verifikasi')->with('pesan', 'Usulan ditolak.');
        } else {
            $kirim=Pendaftaran::find($id);
            $kirim->status = "DISETUJUI";
            $kirim->update();  
            return redirect('/verifikasi')->with('pesan', 'Usulan disetujui.');
        }
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
            return redirect('/verifikasi')->with('pesan', 'Usulan telah di setujui.');
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
      

        // return redirect('/verifikasi/view/'.$id)->with('pesan', 'Usulan telah di tolaks.');
        dd($tolak);
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

        $ids= $request->pendaftaran;
        $sent=Pemberkasan::where('pendaftaran_id',$ids)->update([
            'verifikasi'=>0,
            'alasan_tolak'=>null
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