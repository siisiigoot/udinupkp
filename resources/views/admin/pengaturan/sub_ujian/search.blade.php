@extends('layouts.admin-master')

@section('title', 'Pegawai')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
    <li class="breadcrumb-item active">Pegawai</a></li>
</ol>
@endsection

@section('content')
@if(count($datapegawai))
    <h4 class="mt-0 header-title">Data Pegawai</h4>
    <p class="text-muted m-b-30">Pemerintah Daerah Provinsi Jawa Barat.
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <form action="{{ route('pegawai.search') }}" method="GET">
                @csrf
                <div class="input-group mb-3 pull-right">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan NIP . . ." name="kata" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-search" id="button-addon2"></i> Cari </button>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Ditemukan <strong>{{ count($datapegawai) }}</strong> data dengan pencarian "<strong>{{ $cari }}</strong>"
    </div>   

    <div class="table-responsive b-0" data-pattern="priority-columns">
        <table class="table table-sm table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Golongan</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Perangkat Daerah</th>
                    <th>Instansi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        <body>
            @foreach ($datapegawai as $no => $pegawai )                   
            <tr>
                <td>{{ $datapegawai->firstitem()+$no }}</td>
                <td>{{ $pegawai->nip }}</td>
                <td>{{ $pegawai->nama }}</td>
                <td>{{ $pegawai->jk }}</td>
                <td>{{ $pegawai->gol }}</td>
                <td>{{ $pegawai->jab }}</td>
                <td>{{ $pegawai->unkerja }}</td>
                <td>{{ $pegawai->pd }}</td>
                <td>{{ $pegawai->instansi }}</td>     
                <td>
                    <a href="{{ route('pegawai.view',$pegawai->id) }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-search"></i> Lihat Detil</a>
                </td>              
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div>{{ $datapegawai->links() }}</div>
    @else
    <h4 class="mt-0 header-title">Data Pegawai</h4>
    <p class="text-muted m-b-30">Pemerintah Daerah Provinsi Jawa Barat.
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <form action="{{ route('pegawai.search') }}" method="GET">
                @csrf
                <div class="input-group mb-3 pull-right">
                    <input type="text" class="form-control" placeholder="Cari data pegawai..." name="kata" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-search" id="button-addon2"></i> Cari </button>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <div class="alert alert-success bg-danger text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Tidak ditemukan data dengan pencarian "<strong>{{ $cari }}</strong>"
    </div>   
    <div>
        Klik <a class="btn btn-primary btn-sm" href='/pegawai'>disini</a> untuk refresh halaman
    </div>
@endif
@endsection

@push('page-script')

@endpush