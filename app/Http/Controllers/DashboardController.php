<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Pendaftaran;

class DashboardController extends Controller
{
    
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
    $totalusulan = Pendaftaran::count();
    $usulanbaru = Pendaftaran::where('status','BARU')->count();
    $usulanver = Pendaftaran::where('status','VERIFIKASI')->count();
    $usulanacc = Pendaftaran::where('status','DISETUJUI')->count();
    return view('admin.dashboard.index', compact('usulanacc','usulanver','usulanbaru','totalusulan'));
    }
}
