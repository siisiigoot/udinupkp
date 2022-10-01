@extends('layouts.admin-master')

@section('title', 'Daftar Usulan')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
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
{{-- <div class="row">
    <div class="col-md-6">
        <div class="pull-right" role="toolbar">
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah Usulan</a>
        </div>            
    </div>
    <div class="col-md-6"> 
    </div>
</div> --}}
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
            <td class="text-center">{{$data->periode }}</td>
            <td>
                {{ $data->pegawai->nip }} /<br>
                {{ $data->pegawai->nama }} /<br>
                {{ $data->pegawai->gol }}
            </td>  
            <td>
                {{ $data->pegawai->ting_pend }} / <br>
                {{ $data->pegawai->jab }}
            </td>  
            <td class="text-left">
                {{ $data->pegawai->unkerja }} /<br>
                {{ $data->pegawai->pd }}
            </td>
            <td>{{ $data->subujian->nama_subujian }}</td>
            <td class="text-center">
                @if ($data->status === 'BARU')
                    <span class="badge-warning badge mr-2">{{ $data->status }}</span></td>
                @elseif ($data->status === 'VERIFIKASI')
                    <span class="badge-info badge mr-2">{{ $data->status }}</span></td>
                @else
                    <span class="badge-success badge mr-2">{{ $data->status }}</span></td>
                @endif
            <td class="text-center">
                @if ($data->status <> 'BARU')
                        <a href="{{ route('verifikasi.view', $data->id) }}" class="btn btn-icon icon-left btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Lihat Usulan"><i class="fas fa-search"></i></a>
                @else
                    <form action="{{ route('verifikasi.destroy', $data->id) }}" method="post">
                        @csrf
                        <a href="{{ route('verifikasi.view', $data->id) }}" class="btn btn-icon icon-left btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Lihat Usulan"><i class="fas fa-search"></i></a>
                        <button class="btn btn-icon icon-left btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Hapus usulan" onClick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i></button>
                        <input type="hidden" name="nip" value="{{ $data->pegawai->nip }}">
                    </form>
                @endif
            </td>              
        </tr>
        @endforeach
    </tbody>
    </table>
</div>
<div class="pagination justify-content-center">{{ $datapendaftaran->appends(request()->except('page'))->links() }}</div>

@endsection


@push('page-script')

@endpush