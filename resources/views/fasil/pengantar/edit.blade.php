@extends('layouts.admin-master')

@section('title', 'Surat Pengantar')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Fasilitator</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Surat Pengantar</a></li>
    <li class="breadcrumb-item active">Ubah data</a></li>
</ol>
@endsection

@section('content')
<h4 class="mt-0 header-title">Ubah Data</h4>
<p class="text-muted m-b-30"></p>
@if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger bg-info text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Mohon periksa kembali</strong>, semua isian harus di input...
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
<form method="post" action="{{ route('pengantar.update') }}" enctype="multipart/form-data">
    @csrf
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label" hidden>id</label>
            <div class="col-sm-2" hidden>
                <input class="form-control" type="text" id="pengantarid" name="pengantarid" value="{{ $datapengantar->id }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">No Surat</label>
            <div class="col-sm-6">
                <input class="form-control" type="text" id="no_surat" name="no_surat" value="{{ $datapengantar->nomor }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Surat</label>
            <div class="col-sm-3">
                <input class="date form-control" type="date" id="tgl_surat" name="tgl_surat" value="{{ $datapengantar->tanggal }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Perihal</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" id="perihal" name="perihal">{{ $datapengantar->perihal }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Lampiran</label>
            <div class="col-sm-10">
                <a href="{{ asset('uploads/pengantar/'. $datapengantar->file) }}" target="_blank">
                <i class="fas fa-file-pdf"></i>
                <label for="example-text-input" class="col-form-label">{{ $datapengantar->file }}</label></a>
            </div>
        </div>
        <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="file" class="filestyle" data-buttonname="btn-secondary" name="file" accept="application/pdf">
                    <label for="example-text-input" class="col-form-label text-danger">*)Apabila tidak diganti, kosongkan saja.</label>
                </div>
        </div>
        <div class="form-group row">
            <label for="example-search-input" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <div>
                    <a href="{{ route('pengantar') }}" class="btn btn-secondary waves-effect m-l-5">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection


@push('page-script')

@endpush