@extends('layouts.admin-master')

@section('title', 'Usulan Peserta')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Fasilitator</a></li>
    <li class="breadcrumb-item active">Usulan peserta</a></li>
</ol>
@endsection

@section('content')
@if (Session::has ('pesan'))
<div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ Session::get('pesan') }}</strong>
</div>   
@endif
<div class="row">
    <div class="col-md-6">
        <div class="pull-right" role="toolbar">
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah Usulan</a>
        </div>            
    </div>
    <div class="col-md-6"> 
    </div>
</div>
<br>

<div class="table-responsive b-0" data-pattern="priority-columns">
    <table id="datatable" class="table table-sm table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr class="text-center">
                <th style="width: 5%;">No</th>
                <th style="width: 5%;">Periode</th>
                <th  style="width: 20%;">
                    NIP / Nama / Golongan
                </th>
                <th style="width: 20%;">
                    Pendidikan / Jabatan
                </th>
                <th style="width: 20%;">
                    Unit Kerja / Perangkat Daerah
                </th>
                <th style="width: 10%;">Jenis Ujian</th>
                <th style="width: 5%;">Status</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
    <body>
        @foreach ($datapendaftaran as $data )                   
        <tr>
            <td class="text-center">{{ ++$no }}</td>
            <td class="text-center">{{ $data->periode }}</td>
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
            <td>{{ $data->nama_subujian }}</td>
            <td class="text-center">
                @if ($data->status === 'DRAFT')
                    <span class="badge-warning badge mr-2">{{ $data->status }}</span></td>
                @elseif ($data->status === 'BARU')
                    <span class="badge-warning badge mr-2">{{ $data->status }}</span></td>
                @elseif ($data->status === 'VERIFIKASI')
                    <span class="badge-info badge mr-2">{{ $data->status }}</span></td>
                @elseif ($data->status === 'DITOLAK')
                    <span class="badge-danger badge mr-2">{{ $data->status }}</span></td>
                @else
                    <span class="badge-success badge mr-2">{{ $data->status }}</span></td>
                @endif
            <td class="text-center">
                @if ($data->status <> 'BARU')
                <form action="{{ route('pendaftaran.destroy', $data->id) }}" method="post">
                @csrf
                    <a href="{{ route('pendaftaran.view', $data->id) }}" class="btn btn-icon icon-left btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Lihat Usulan"><i class="fas fa-search"></i></a>

{{--                     <button class="btn btn-icon icon-left btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Hapus usulan" onClick="return confirm('Yakin mau dihapus?')" disabled><i class="fas fa-trash"></i></button> --}}
                    <input type="hidden" name="nip" value="{{ $data->nip }}">
                </form>
                @else
                <form action="{{ route('pendaftaran.destroy', $data->id) }}" method="post">
                @csrf
                    <a href="{{ route('pendaftaran.view', $data->id) }}" class="btn btn-icon icon-left btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="unggah dokumen"><i class="fas fa-folder-open"></i></a>

                    <button class="btn btn-icon icon-left btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="batalkan usulan" onClick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i></button>
                    <input type="hidden" name="nip" value="{{ $data->nip }}">
                </form>
                @endif 
            </td>              
        </tr>
        @endforeach
    </tbody>
    </table>
</div>

@endsection


@push('page-script')

@endpush