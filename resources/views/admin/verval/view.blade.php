@extends('layouts.admin-master')

@section('title', 'Usulan Peserta')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Fasilitator</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Usulan Peserta</a></li>
    <li class="breadcrumb-item active">{{ $datapendaftaran->pegawai->nip }}</a></li>
</ol>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger bg-danger text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Tidak dapat diverifikasi!</strong> Mohon Periksa kembali dokumen yang akan di unggah...
    </div>
@endif
@if (Session::has ('pesan'))
    <div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('pesan') }}!</strong>
    </div>   
@endif
@if (Session::has ('gagal'))
    <div class="alert alert-info bg-info text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('gagal') }}!</strong>
    </div>   
@endif
<div class="row">
    <div class="col-md-6">
        <div class="pull-right" role="toolbar">
                <a href="{{ route('verifikasi') }}" class="btn btn-icon icon-left btn-secondary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
        </div>            
    </div>
    <div class="col-md-6">
        @if ($datapendaftaran->status === 'VERIFIKASI')
            {{-- cek jika status baru --}}
            @if ($datapendaftaran->subujian->id < 3 and $hitung === 4)
                <form action="{{ route('verifikasi.kirim') }}" method="post">
                    @csrf
                    <div class="text-right" role="toolbar">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Terima <i class="fas fa-check-circle"></i></button>
                    </div>  
                    {{-- UDIN<br> --}}
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                    <input type="hidden" name="jumlahberkas" value="{{ $hitung }}"><br>
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                </form>
            @elseif ($datapendaftaran->subujian->id > 2 and $hitung === 10)
                <form action="{{ route('verifikasi.kirim') }}" method="post">
                    @csrf
                    <div class="text-right" role="toolbar">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Terima <i class="fas fa-check-circle"></i></button>
                    </div>  
                    {{-- UPKP<br> --}}
                    <input type="text" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                    <input type="text" name="jumlahberkas" value="{{ $hitung }}"><br>
                    <input type="text" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                </form>
            @else
                <div class="text-right" role="toolbar">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <form action="{{ route('verifikasi.kembalikan') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-warning waves-effect waves-light">Kembalikan <i class="fas fa-exclamation-circle"></i></button>
                            <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                            <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                        </form>
                        <form>
                            @csrf
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#exampleModal">Tolak <i class="far fa-times-circle"></i></button>
                            <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                            <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                        </form>
                        <form action="{{ route('verifikasi.kirim') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Terima <i class="fas fa-check-circle"></i></button>
                            <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                            <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                        </form>
                    </div>
                </div>
            @endif
        @elseif ($datapendaftaran->status === 'DISETUJUI')
            <form action="{{ route('verifikasi.batal') }}" method="post">
                @csrf
                <div class="text-right" role="toolbar">
                    <button type="submit" class="btn btn-danger waves-effect waves-light" onClick="return confirm('Apakah yakin verifikasi akan dibatalkan?')">Batalkan <i class="fas fa-undo"></i></button>
                </div>
                <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                <input type="hidden" name="jumlahberkas" value="{{ $hitung }}"><br>
                <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
            </form>
        @endif
    </div>
</div>
<div class="row">
<div class="col-12">
    <div class="invoice-title">
        <h6 class="float-end font-size-14"><strong>Profil Pegawai</strong></h6>
    </div>
    <hr>
    <div class="row">
        <div class="col-8">
            <address>
                <strong>
                    {{ $datapendaftaran->pegawai->nip }}<br>
                    {{ $datapendaftaran->pegawai->nama }}<br>
                </strong>
                    {{ $datapendaftaran->pegawai->jab }}<br>
                    {{ $datapendaftaran->pegawai->unkerja }}<br>
                    {{ $datapendaftaran->pegawai->pd }}<br>
                    {{ $datapendaftaran->pegawai->instansi }}<br><br>
                <strong>
                    <h5>Periode : {{ $datapendaftaran->periode }}</h5>
                </strong>
            </address>
        </div>
        <div class="col-4 text-right">
            <address>
                <strong>Status Usulan</strong><br>
                @if ($datapendaftaran->status === 'BARU')
                <span class="badge-warning badge mr-2">{{ $datapendaftaran->status }}</span><br>
                @elseif ($datapendaftaran->status === 'VERIFIKASI')
                <span class="badge-info badge mr-2">{{ $datapendaftaran->status }}</span><br>
                @else
                <span class="badge-success badge mr-2">{{ $datapendaftaran->status }}</span><br>
                @endif <br>
                <strong>Jenis Ujian</strong><br>
                {{ $datapendaftaran->subujian->ket }}<br><br>
                <strong>Progres Unggah Dokumen</strong><br>
                <span class="badge-info badge mr-2"><strong>{{ $hitungsudah }}  /  {{ $hitungberkas }}</strong></span><br>
            </address>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        {{-- @if (count($errors) === 1)
            @foreach($errors->all() as $error)
                <div class="alert alert-warning bg-info text-white alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Perhatian !</strong> Anda belum memilih dokumen untuk diunggah.
                </div>
            @endforeach
        @endif --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success  alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>  
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 45%;">Nama Dokumen</th>
                        <th style="width: 20%;">Keterangan</th>
                        <th style="width: 15%;">Dokumen</th>
                        <th style="width: 20%;">Verifikasi</th>
                    </tr>
                </thead>
            <body>
                @foreach ($datapemberkasan as $data )                   
                <tr>
                    <td class="text-center">{{ ++$no }}</td>
                    <td class="text-left">{{ $data->ket }}</td>  
                    <td class="text-center">{{ $data->nama_dokumen }}</td>  
                    <td class="text-center">
                        @if ($data->file === ' ')
                            <span class="badge-danger badge mr-2">Belum</span>
                        @else                       
                            <a href="{{ asset('uploads/'.$data->folder.'/'. $data->file) }}" target="_blank" class="badge-success badge mr-2"> Lihat Dokumen </a>  
                        @endif
                        
                    </td>
                    <td class="text-center">
                        @if ($datapendaftaran->status === 'BARU' OR $datapendaftaran->status === 'DISETUJUI')
                            <div class="form-check form-switch">
                                <input data-id="{{$data->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $data->verifikasi ? 'checked' : '' }} disabled>
                            </div>
                        @else

                        <div class="form-check form-switch">
                            <input data-id="{{$data->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $data->verifikasi ? 'checked' : '' }}>
                        </div>
                        @endif
                        
{{--                         <form action="{{ route('pendaftaran.destroy', $data->id) }}" method="post">
                        @csrf
                            <button class="btn btn-icon icon-left btn-danger btn-sm" onClick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i></button>
                        </form> --}}
                    </td>              
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-0">
    </div>
</div>


  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alasan Tolak</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('verifikasi.tolak') }}" method="post">
        @csrf
        <input type="text" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
        <div class="modal-body">
            @foreach ($tolak as $dt => $n)
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">
                    {{ $n->nama_dokumen }} {{ $n->id }}
                    </label> 
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="inputAlasan[]" placeholder="{{ $n->nama_dokumen }}">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

@endsection