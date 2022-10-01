<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('checkrole');
    }

    public function index(){
        $batas = 5;
        $datauser = User::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($datauser->currentPage() - 1);
        return view('admin.user.index', compact('datauser', 'no'));    
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'password'=>'required|confirmed|min:8',
            'email'=>'required|email|unique:users'
        ]);
        $datauser = New User;
        $datauser->name     = $request->nama;
        $datauser->email    = $request->email;
        $datauser->level    = $request->role;
        $datauser->password = bcrypt($request->password);
        $datauser->save();
        return redirect('/user')->with('pesan', 'Data User berhasil disimpan');
    }

    public function edit($id){
        $datauser = User::find($id);
        return view('admin.user.edit', compact('datauser'));
    }

    public function update(Request $request, $id){
        $datauser = User::find($id);
        if($request->input('password')){
            $datauser->name     = $request->nama;
            $datauser->email    = $request->email;
            $datauser->role    = $request->role;    
            $datauser->password = bcrypt($request->password);
        }
        else{
            $datauser->name     = $request->nama;
            $datauser->email    = $request->email;
            $datauser->role    = $request->role;
    
        }
        $datauser->update();
        return redirect('/user')->with('pesan','Data User berhasil di update');
    }

    public function destroy($id){
        $datauser = User::find($id);
        $datauser->delete();
        return redirect('/user')->with('pesan', 'Data User berhasil di hapus');
    }
}
