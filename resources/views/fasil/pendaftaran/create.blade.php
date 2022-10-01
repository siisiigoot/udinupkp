@extends('layouts.admin-master')

@section('title', 'Usulan Peserta')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Fasilitator</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Usulan</a></li>
    <li class="breadcrumb-item active">Tambah data peserta</a></li>
</ol>
@endsection

@section('content')
@if (count($errors) >0)
    <div class="alert alert-danger bg-info text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>isian NIP masih kosong,</strong> mohon periksa kembali..
    </div>
@endif
@if (Session::has ('pesan'))
    <div class="alert alert-success bg-info text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('pesan') }}!</strong>
    </div>   
@endif
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('pendaftaran.search') }}" method="GET" role="search">
            @csrf
            <div class="form-group">
                    <div class="input-group mb-3 pull-right">
                        <input type="text" class="form-control" placeholder="Cari data pegawai..." name="nip">
                        <div class="input-group-append">
                            <button class="btn btn-icon icon-left btn-secondary" type="submit"><i class="fas fa-search"></i> NIP </button>
                        </div>
                    </div>
            </div>
        </form>
{{--             <div class="form-group">
                <select class="form-control select2" name="jenis_ujian">
                    <option selected disabled>--Pilih Jenis Ujian--</option>
                    @foreach($datasubujian as $group => $data)
                        <optgroup label="@if($group==1) UDIN @else UPKP @endif">
                            @foreach($data as $d)
                                <option value="{{$d->id}}">{{$d->nama_subujian}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <a href="{{ route('pendaftaran.create') }}" class="btn btn-block btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah</a>
            </div> --}}
       
    </div>
    <div class="col-md-1">
    </div>
    <div class="col-md-7">
        <div class="table-responsive pull-right">
            <table class="table table-sm table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <tr>
                    <td style="width: 25%;">NIP</td>
                    <td style="width: 75%;"> - </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Golongan</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Perangkat Daerah</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <td> - </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-8">
    </div>
</div>

@endsection


@push('page-script')

@endpush