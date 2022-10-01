@extends('layouts.admin-master')

@section('title', 'Pegawai')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
    <li class="breadcrumb-item active">Pegawai</a></li>
</ol>
@endsection

@section('content')
ination justify-content-center">{{ $datapegawai->appends(request()->except('page'))->links() }}</div>
    
@endsection

@push('page-script')

@endpush