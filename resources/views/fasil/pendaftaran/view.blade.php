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
@if (count($errors) === 2)
    <div class="alert alert-danger bg-danger text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Tidak dapat diajukan!</strong> dokumen tidak lengkap...
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
<div class="row">
    <div class="col-md-6">
        <div class="pull-right" role="toolbar">
                <a href="{{ route('pendaftaran') }}" class="btn btn-icon icon-left btn-secondary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
        </div>            
    </div>
    <div class="col-md-6">
        {{-- cek jika status baru --}}
        @if ($datapendaftaran->status === 'BARU')
            {{-- cek jika jenis ujian adalah udin dan berkas lengkap--}}
            @if ($datapendaftaran->subujian->id < 3 and $hitung === 0)
{{--                 <form action="{{ route('pendaftaran.kirim') }}" method="post">
                    @csrf --}}
                    @if ($jumlahpengantar === 0 )
                        <div class="text-right" role="toolbar">
                            <a class="btn btn-primary waves-effect waves-light" onClick="return confirm ('Belum ada surat pengantar. Silahkan buat surat pengantar terlebih dahulu...')" href="{{ route('pengantar.create') }}">Usulkan <i class="fas fa-check-circle"></i></a>
                        </div> 
                    @else
                        <div class="text-right" role="toolbar">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">Usulkan <i class="fas fa-check-circle"></i></button>
                        </div>   
                    @endif
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}">
                    <input type="hidden" name="jumlahberkas" value="{{ $hitung }}">
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}">
{{--                 </form> --}}
            {{-- cek jika jenis ujian adalah upkp dan berkas lengkap--}}
            @elseif ($datapendaftaran->subujian->id > 2 and $hitung === 0)
{{--                 <form action="{{ route('pendaftaran.kirim') }}" method="post">
                    @csrf --}}
                    @if ($jumlahpengantar === 0 )
                        <div class="text-right" role="toolbar">
                            <a class="btn btn-primary waves-effect waves-light" onClick="return confirm ('Belum ada surat pengantar. Silahkan buat surat pengantar terlebih dahulu...')" href="{{ route('pengantar.create') }}">Usulkan <i class="fas fa-check-circle"></i></a>
                        </div> 
                    @else
                        <div class="text-right" role="toolbar">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">Usulkan <i class="fas fa-check-circle"></i></button>
                        </div>   
                    @endif
                    <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}">
                    <input type="hidden" name="jumlahberkas" value="{{ $hitung }}">
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}">
{{--                 </form> --}}
            @else
            {{-- jika tidak --}}
                <form action="{{ route('pendaftaran.kirim') }}" method="post">
                    @csrf
                    <div class="text-right" role="toolbar">
                        <button type="button" class="btn btn-primary waves-effect waves-light" onClick="return alert ('Berkas Belum Lengkap. Silahkan lengkapi berkas yang akan di unggah...')">Usulkan <i class="fas fa-check-circle"></i></button>
                    </div>     
                    <input type="hidden" name="subujian" value="">
                    <input type="hidden" name="pendaftaran" value="">
                </form>
    {{--         <form action="#">
                <div class="text-right" role="toolbar">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-basic">Click me</button>
                </div>   

                </form> --}}
            @endif
        @else
            
        @endif
    </div>
</div>
<br>
<div class="col-12">
    <div class="row">
        <div class="col-6">
            <h6 class="float-end font-size-14"><strong>Profil Pegawai</strong></h6>
        </div>
        @if ($datapendaftaran->status <> 'BARU')
            <div class="col-6">
{{--                 <div class="text-right">Surat Pengantar : 
                    <br><strong><small>{{ $nosurat->pengantar->nomor }}</small></strong> | 
                    <strong><small>{{ $nosurat->pengantar->tanggal->format('d-m-Y') }}</small></strong> --}}
                </div>
            </div>
        @endif
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
                @if ($datapendaftaran->status === 'DRAFT')
                <span class="badge-warning badge mr-2">{{ $datapendaftaran->status }}</span><br>
                @elseif ($datapendaftaran->status === 'BARU')
                <span class="badge-warning badge mr-2">{{ $datapendaftaran->status }}</span><br>
                @elseif ($datapendaftaran->status === 'VERIFIKASI')
                <span class="badge-info badge mr-2">{{ $datapendaftaran->status }}</span><br>
                @elseif ($datapendaftaran->status === 'DITOLAK')
                <span class="badge-danger badge mr-2">{{ $datapendaftaran->status }}</span><br>
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
<br>
<div class="invoice-title text-center">
    <h6 class="float-end font-size-14"><strong>Dokumen Persyaratan</strong></h6>
</div>
<div class="row">
    <div class="col-md-12">
        @if (count($errors) === 1)
            @foreach($errors->all() as $error)
                <div class="alert alert-warning bg-info text-white alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Perhatian !</strong> Anda belum memilih dokumen untuk diunggah.
                </div>
            @endforeach
        @endif
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
                        <th style="width: 15%;">Unggah Dokumen</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datapemberkasan as $data )                   
                    <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td class="text-left">{{ $data->ket }}</td>  
                        <td class="text-center">{{ $data->nama_dokumen }}</td>  
                        <td class="text-center">
                            @if ($data->file === ' ')
                                <span class="badge badge-danger rounded-pill mr-2">Belum</span>
                            @else                       
                                <a href="{{ asset('uploads/'.$data->folder.'/'. $data->file) }}" target="_blank" class="badge-success badge mr-2"> Lihat Dokumen </a>  
                            @endif 
                        </td>
                        <td class="text-center">
                            @if ($datapendaftaran->status === 'VERIFIKASI')
                            <span class="badge badge-info mr-2">Verifikasi</span>
                            @elseif ($datapendaftaran->status === 'DISETUJUI')
                            <span class="badge badge-success mr-2">Disetujui</span>
                            @elseif ($datapendaftaran->status === 'DITOLAK')
                            <span class="badge badge-danger mr-2">Ditolak</span>
                            @else
                            <form action="{{ route('pendaftaran.upload') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if ($data->nama_dokumen === 'Foto')
                                    <div class="btn-group" role="group" aria-label="Basic example" data-toggle="tooltip" data-placement="bottom" title="unggah {{ $data->nama_dokumen }}">
                                        <input type="file" name="foto" class="filestyle form-control" data-input="false" data-buttonname="btn-secondary" data-toggle="tooltip" data-placement="bottom" title="unggah dokumen" accept="image/jpeg,  image/png, image/jpg">
                                        <button class="btn btn-primary btn-sm">Simpan <i class="fas fa-upload"></i></button>
                                    </div>   
                                @else
                                    <div class="btn-group" role="group" aria-label="Basic example" data-toggle="tooltip" data-placement="bottom" title="unggah {{ $data->nama_dokumen }}">
                                        <input type="file" name="file" class="filestyle form-control" data-input="false" data-buttonname="btn-secondary" data-toggle="tooltip" data-placement="bottom" title="unggah dokumen" accept="application/pdf">
                                        <button class="btn btn-primary btn-sm">Simpan <i class="fas fa-upload"></i></button>
                                    </div>                               
                                @endif
                                <input type="hidden" name="pemberkasanid" value="{{ $data->id }}"><a href="{{ $data->id }}"></a>
                                <input type="hidden" name="nip" value="{{ $datapendaftaran->pegawai->nip }}"><a href="{{ $data->id }}"></a>
                                <input type="hidden" name="namadok" value="{{ $data->nama_dokumen }}"><a href="{{ $data->id }}"></a>
                            </form>
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


<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pendaftaran.kirim') }}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Pilih Surat Pengantar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-12">
                    <label class="col-md-4 col-form-label">Surat Pengantar :</label>
                    <div class="col-md-12">
{{-- 
                        @foreach($errors->pengantar() as $error)
                            <div class="alert alert-warning bg-info text-white alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Perhatian !</strong> Anda belum memilih dokumen untuk diunggah.
                            </div>
                        @endforeach --}}

                        @if ($jumlahpengantar === 0 )
                        <div class="alert alert-danger bg-danger text-white alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Belum ada surat pengantar... Silahkan Buat surat pengantar terlebih dahulu...</strong>
                        </div>   
                        @endif
                        <select class="form-control select2" name="pengantar">
                            <option selected disabled>--pilih--</option>
                            @foreach($datapengantar as $data)
                                <option value="{{$data->id}}">Nomor: {{$data->nomor}} | Tanggal: {{$data->tanggal->format('d-m-Y')}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}">
                        <input type="hidden" name="jumlahberkas" value="{{ $hitung }}">
                        <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="cancel" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Usulkan</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection