@extends('layouts.admin-master')

@section('title', 'Pegawai')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Pegawai</a></li>
    <li class="breadcrumb-item active">{{ $datapegawai->nip }}</li>
</ol>
@endsection

@section('content')
<div class="card-body">
            
{{--        <h4 class="mt-0 header-title">Textual inputs</h4>
        <p class="text-muted m-b-30">Here are examples of <code
                class="highlighter-rouge">.form-control</code> applied to each
            textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code
class="highlighter-rouge">type</code>.</p> --}}
        <form method="post" action="{{ route('pegawai.view', $datapegawai->id) }}">
            @csrf
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">NIP</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->nip }}" id="example-text-input">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->nama }}" id="example-text-input">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->jk }}" id="example-text-input">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Golongan Ruang</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->gol }}" id="example-text-input">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Jenis Jabatan</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->jns_jab }}" id="example-text-input">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" value="{{ $datapegawai->jab }}" id="example-text-input">
                </div>
				{{--                <div class="col-sm-2">
                    <a href="{{ route('pegawai.editjabatan') }}"> <input type="button" class="btn btn-success form-control"></a>
                </div>--}}
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Unit Kerja</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->unkerja }}" id="example-text-input">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Instansi</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $datapegawai->instansi }}" id="example-text-input">
                </div>
            </div>
        </form>
</div>
@endsection