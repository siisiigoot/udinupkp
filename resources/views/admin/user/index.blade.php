@extends('layouts.admin-master')

@section('title', 'Pengaturan Akun')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan</a></li>
    <li class="breadcrumb-item active">Akun</a></li>
</ol>
@endsection

@section('content')
@if (Session::has ('pesan'))
<div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ Session::get('pesan') }}!</strong>
</div>   
@endif

<div class="btn-toolbar p-2" role="toolbar">
    <a href="{{ route('user.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah</a>
</div>

<table class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Level</th>
            <th>Perangkat Daerah</th>
            <th>Aksi</th>
        </tr>
    </thead>
<body>
    @foreach ($datauser as $data )                   
    <tr>
        <td>{{ ++$no }}</td>
        <td>{{ $data->name }}</td>  
        <td>{{ $data->email }}</td>
        <td>{{ $data->role }}</td>
        <td>{{ $data->nama_pd }}</td>

        <td>
        <form action="{{ route('user.destroy', $data->id) }}" method="post">
        @csrf
            <a href="{{ route('user.edit',$data->id) }}" class="btn btn-icon icon-left btn-warning btn-sm"><i class="fas fa-edit"></i> Ubah</a>
            <button class="btn btn-icon icon-left btn-danger btn-sm" onClick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Hapus</button>
        </form>
        </td>              
    </tr>
    @endforeach
</tbody>
</table>

@endsection


@push('page-script')

@endpush