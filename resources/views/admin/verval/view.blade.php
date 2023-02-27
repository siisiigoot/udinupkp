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
        <div class="text-right" role="toolbar">
            <div class="btn-group" role="group" aria-label="Basic example">
                <form action="{{ route('verifikasi.kembalikan') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Reset <i class="fas fa-exclamation-circle"></i></button>
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                </form>
                {{-- <form action="{{ route('verifikasi.tolak') }}" method="post"> --}}
                    {{-- @csrf --}}
                {{-- <form>
                    @csrf --}}
                    {{-- <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#exampleModal">xx <i class="far fa-times-circle"></i></button>
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}">
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"> --}}
                {{-- </form> --}}
                    {{-- @csrf
                    <button type="button" class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#exampleModal">Tolak <i class="far fa-times-circle"></i></button>
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br> --}}
                {{-- </form> --}}
                <form>
                    @csrf
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#exampleModal" {{ $datapendaftaran->status === 'BARU' || $datapendaftaran->status === 'DISETUJUI' || $datapendaftaran->status === 'DITOLAK' ? 'disabled' : '' }}>Verifikasi <i class="fas fa-check-circle"></i></button>
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                </form>
            </div>
        </div>
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
                        <th style="width: 20%;">Ceklis</th>
                    </tr>
                </thead>
            <body>
                @foreach ($datapemberkasan as $data )                   
                <tr>
                    <td class="text-center">{{ ++$no }}</td>
                    <td class="text-left">{{ $data->ket }} <br> @if($data->alasan_tolak)<span class='text-danger font-italic' >*{{ $data->alasan_tolak }} @endif</span></td>  
                    <td class="text-center">{{ $data->nama_dokumen }}</td>  
                    <td class="text-center">
                        @if ($data->file === ' ')
                            <span class="badge-danger badge mr-2">Belum unggah</span>
                        @else                       
                            <a href="{{ asset('uploads/'.$data->folder.'/'. $data->file) }}" target="_blank" class="badge-success badge mr-2"> Lihat Dokumen </a>  
                        @endif
                        
                    </td>
                    <td class="text-center">
                        @if ($data->status == "BARU")
                            <span class="badge badge-dark badge-pill"><i class="mdi mdi-checkbox-blank-circle text-light"></i> Pending</span>
                        @elseif ($data->status == "DISETUJUI")
                            <span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-light"></i> oke</span>
                        @elseif ($data->status == "DITOLAK")
                            <span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-light"></i> Pending</span>
                        @else
                            <div class="btn-group btn-group-sm btn-group-toggle" aria-label="Basic example" data-toggle="buttons">
                                <label data-id="{{$data->id}}" data-value="1" class="btn btn-sm waves-effect waves-light {{ $data->verifikasi == 1 ? 'btn-success' : 'btn-light btn-sm waves-effect waves-success toggle-class' }} ">
                                    <input value="1" data-id="{{$data->id}}" type="radio" name="options" id="option1" autocomplete="off" {{ $data->verifikasi == 1 ? 'checked' : '' }}> Terima
                                </label>
                                <label  data-id="{{$data->id}}" data-value="2" class="btn btn-sm waves-effect waves-light {{ $data->verifikasi == 2 ? ' btn-danger' : 'btn-light btn-sm waves-effect waves-danger toggle-class' }}">
                                    <input value="2"  type="radio" name="options" id="option1" autocomplete="off" {{ $data->verifikasi == 2 ? 'checked' : '' }}> Tolak
                                </label>
                            </div>
                        @endif
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
  <div id="exampleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="card-body">
                <h4 class="mt-0 header-title">Resume Verifikasi</h4>
                @if ($hitungxxx > 0)
                <p class="text-muted m-b-5"> <code>Tidak dapat Diverifikasi</code>. Cek kembali dokumen.
                </p>
                @else
                    @if ($hitungtolak>0)
                        <p class="text-muted m-b-5">Terdapat <code>{{ $hitungtolak }}</code> dokumen yang <span class="badge badge-danger">DITOLAK</span>.
                        </p>
                    @else
                    <p class="text-muted m-b-5">Semua dokumen telah <span class="badge badge-success">DISETUJUI</span>.
                    </p>
                    @endif
                @endif
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Dokumen</th>
                            <th class="text-center">Verifikasi</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tolak as $dt )
                        <tr>
                            <td class="text-center">{{ ++$urut }}</td>
                            <td class="text-left">{{ $dt->nama_dokumen }}</td>
                            <td class="text-center">
                                @if ($dt->verifikasi == 1)
                                <i class="far fa-check-circle" style='font-size:24px; color:#28a745'></i>
                                @elseif ($dt->verifikasi == 2)
                                <i class="far fa-times-circle" style='font-size:24px; color:#dc3545;'></i>
                                @else
                                <i class="fas fa-question-circle" style='font-size:24px; color:#6c757d;'></i>
                                @endif
                            </td class="text-center">
                            <td class="text-left">{{ $dt->verifikasi == 2 ? 'Alasan Tolak :' : '' }}<br />{{ $dt->alasan_tolak }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <form action="{{ route('verifikasi.proses') }}" method="post">
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}"><br>
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"><br>
                    @csrf
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn {{ $hitungtolak == 0 ? 'btn-success' : 'btn-danger' }} waves-effect waves-light" {{ $hitungxxx == 0 ? '' : 'disabled' }}>{{ $hitungtolak == 0 || $hitungxxx <> 0 ? 'Verifikasi' : 'Tolak' }}
                    </button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection