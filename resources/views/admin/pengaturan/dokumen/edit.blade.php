@extends('layouts.admin-master')

@section('title', 'Master Data Dokumen')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan</a></li>
    <li class="breadcrumb-item">Master Data Dokumen</a></li>
    <li class="breadcrumb-item active">Ubah Data</a></li>
</ol>
@endsection

@section('content')

<h4 class="mt-0 header-title">Ubah Data Dokumen</h4>
<p class="text-muted m-b-30"></p>
@if (count($errors)>0)
    <ul class="alert alert-danger bg-danger text-white alert-dismissible fade show">
        @foreach ($errors->all() as $error )
            <li>{{ $error }}</li>
        @endforeach
    </ul> 
@endif
<form method="post" action="{{ route('dokumen.update', $datadokumen->id) }}">
@csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jenis Ujian</label>
        <div class="col-sm-10">
            <select class="form-control" id="ujian" name="ujian">
                @foreach ($dataujian as $data )
                <option value="{{ $data->id }}">{{ $data->nama_ujian }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Nama Dokumen</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="nama_dokumen" name="nama_dokumen" value="{{ $datadokumen->nama_dokumen }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" id="ket" name="ket">{{ $datadokumen->ket }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <div>
                <a href="{{ route('dokumen') }}" class="btn btn-secondary waves-effect m-l-5">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    Ubah
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@push('page-script')

@endpush