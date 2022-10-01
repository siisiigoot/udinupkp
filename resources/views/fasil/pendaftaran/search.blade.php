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
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger bg-warning text-white alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $error }}...</strong> 
        </div>
    @endforeach
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
    <div class="col-md-4">
        <div class="form-group">
            <form action="{{ route('pendaftaran.search') }}" method="GET">
                @csrf
                <div class="input-group mb-3 pull-right">
                    <input type="text" class="form-control" placeholder="Cari data pegawai..." name="nip" value="{{ $datapegawai->nip }}">
                    <div class="input-group-append">
                        <button class="btn btn-icon icon-left btn-secondary" type="submit"><i class="fas fa-search"></i> NIP </button>
                    </div>
                </div>
            </form>
        </div>
        <form action="{{ route('pendaftaran.store') }}" method="post">
            @csrf
            <div class="form-group">
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
                <select class="form-control select2" name="periode">
                    <option selected disabled>--Pilih Periode--</option>
                    <option>2021-10</option>
                    <option>2022-04</option>
                    <option>2022-10</option>
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="pegawai_id" value="{{ $datapegawai->id }}">
            </div>
            <div class="form-group">
                <input type="hidden" id="ujian" name="ujian_id" value="{{ $datapegawai->nip }}">
            </div>
{{--             <div class="form-group">
                <input type="text" name="pemberkasanid" value="{{ $last->id }}">
            </div> --}}
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Usulkan </button>
            </div>
        </form>
{{--         <div class="form-group">
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-block btn-icon icon-left btn-danger"><i class="fas fa-plus"></i> Tambah</a>
        </div> --}}
    </div>
    <div class="col-md-1">
    </div>
    <div class="col-md-7">
        <div class="table-responsive pull-right">
            <table class="table table-sm table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <tr>
                    <td style="width: 25%;">NIP</td>
                    <td style="width: 75%;"> {{ $datapegawai->nip }} </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>{{ $datapegawai->nama }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>{{ $datapegawai->jk }}</td>
                </tr>
                <tr>
                    <td>Golongan</td>
                    <td>{{ $datapegawai->gol }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>{{ $datapegawai->jab }}</td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td>{{ $datapegawai->unkerja }}</td>
                </tr>
                <tr>
                    <td>Perangkat Daerah</td>
                    <td>{{ $datapegawai->pd }}</td>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <td>{{ $datapegawai->instansi }}</td>
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