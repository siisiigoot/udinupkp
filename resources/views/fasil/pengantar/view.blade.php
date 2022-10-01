@extends('layouts.admin-master')

@section('title', 'Usulan Peserta')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Fasilitator</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Surat Pengantar</a></li>
    <li class="breadcrumb-item active">detail</a></li>
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
                <a href="{{ route('pengantar') }}" class="btn btn-icon icon-left btn-secondary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
        </div>            
    </div>
    <div class="col-md-6">
                <form action="{{ route('pengantar.kirim') }}" method="post">
                    @csrf
                    <div class="text-right" role="toolbar">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Kirim <i class="fas fa-paper-plane"></i></button>
                    </div>   
{{--                     <input type="hidden" name="subujian" value="{{ $datapendaftaran->subujian->id }}">
                    <input type="hidden" name="jumlahberkas" value="{{ $hitung }}">
                    <input type="hidden" name="pendaftaran" value="{{ $datapendaftaran->id }}"> --}}
                </form>
    </div>
</div>
<br>
<div class="col-12">
    <div class="invoice-title">
        <h6 class="float-end font-size-14"><strong>Surat Pengantar</strong></h6>
    </div>

    <div class="row">
        <div class="col-6">
            <table class="table table-sm">
                <thead>
                    <tr class="text-left">
                        <td >Nomor Surat</td>
                        <td class="text-left">{{ $datapengantar->nomor }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Surat</td>
                        <td>{{ $datapengantar->tanggal->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>{{ $datapengantar->perihal }}</td>
                    </tr>
                    <tr>
                        <td>File Lampiran</td>
                        <td>
                            <a href="{{ asset('uploads/pengantar/'. $datapengantar->file) }}" target="_blank" class="badge-primary badge mr-2"><i class="fas fa-download"></i> Lihat Surat Pengantar </a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-4 text-right">
            <address>

            </address>
        </div>
    </div>
</div>
<br>
<div class="invoice-title text-center">
    <h6 class="float-end font-size-14"><strong>List Pegawai</strong></h6>
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
                        <tr class="text-center">
                            <th style="width: 5%;">No</th>
                            <th  style="width: 25%;">
                                NIP / Nama / Golongan
                            </th>
                            <th style="width: 20%;">
                                Pendidikan / Jabatan
                            </th>
                            <th style="width: 25%;">
                                Unit Kerja / Perangkat Daerah
                            </th>
                            <th style="width: 10%;">Jenis Ujian</th>
                            <th style="width: 12%;">Aksi</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($datapendaftaran as $data)
                    <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td>
                            {{ $data->nip }} /<br>
                            {{ $data->nama }} /<br>
                            {{ $data->gol }}
                        </td>  
                        <td>
                            {{ $data->ting_pend }} / <br>
                            {{ $data->jab }}
                        </td>  
                        <td class="text-left">
                            {{ $data->unkerja }} /<br>
                            {{ $data->pd }}
                        </td>
                        <td class="text-center">
                            {{ $data->nama_subujian }}
                        </td>              
                        <td class="text-center">
                            <a href="{{ route('pendaftaran.view', $data->id) }}" class="btn btn-icon icon-left btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Lihat Usulan"><i class="fas fa-search"></i></a>
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

@endsection