@extends('layouts.admin-master')

@section('title', 'Pengaturan Akun')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Akun</a></li>
    <li class="breadcrumb-item active">Tambah Data</a></li>
</ol>
@endsection

@section('content')
@if (count($errors)>0)
    <ul class="alert alert-danger bg-danger text-white alert-dismissible fade show">
        @foreach ($errors->all() as $error )
            <li>{{ $error }}</li>
        @endforeach
    </ul> 
@endif
<form method="post" action="{{ route('user.save') }}">
    @csrf
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Akun</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="nama" name="nama">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input class="form-control" type="email" id="email" name="email">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Level</label>
            <div class="col-sm-10">
                <select class="form-control" id="level" name="level">
                    <option selected disabled>--Pilih--</option>
                    <option value="admin">Admin</option>
                    <option value="fasil">Fasilitator</option>
                    <option value="peserta">Peserta</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Perangkat Daerah</label>
            <div class="col-sm-10">
                <select class="form-control select2" id="pd" name="pd">
                    <option selected disabled>--Pilih--</option>
                    @foreach($datapd as $group => $pd)
                        <option value="{{$pd->id}}">
                            {{$pd->nama_pd}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="password" name="password">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Ulangi Password</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
            </div>
        </div>


        <div class="form-group row">
            <label for="example-search-input" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <div>
                    <a href="{{ route('user') }}" class="btn btn-secondary waves-effect m-l-5">
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