@extends('layouts.admin-master')

@section('title', 'Master Data Dokumen')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan</a></li>
    <li class="breadcrumb-item active">Master data dokumen</a></li>
</ol>
@endsection

@section('content')
@if ($jumlahujian===0)
<div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    Master data ujian masih kosong, silahkan tambah data ujian terlebih dahulu <strong></strong> data dengan pencarian
</div> 
<div>
    Klik <a class="btn btn-primary btn-sm" href='/ujian'>disini</a> untuk tambah data ujian
</div>
@else
    @if (Session::has ('pesan'))
        <div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ Session::get('pesan') }}</strong>
        </div>   
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="pull-right" role="toolbar">
                {{--     <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">Tambah</button> --}}
                    <a href="{{ route('dokumen.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah</a>
            </div>            
        </div>
        <div class="col-md-6">
            <form action="{{ route('dokumen.search') }}" method="GET">
                @csrf
                <div class="input-group mb-3 pull-right">
                    <input type="text" class="form-control" placeholder="Cari data dokumen..." name="kata" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-search" id="button-addon2"></i> Cari </button>
                        </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive b-0" data-pattern="priority-columns">
        <table class="table table-sm table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Dokumen</th>
                    <th style="width: 40%;">Keterangan</th>
                    <th style="width: 15%;">Jenis Ujian</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
        <body>
            @foreach ($datadokumen as $data )                   
            <tr>
                <td class="text-center">{{ ++$no }}</td>
                <td>{{ $data->nama_dokumen }}</td>  
                <td>{{ $data->ket }}</td>  
                <td>{{ $data->ujian->nama_ujian }}</td>
                <td class="text-center">
                    <form action="{{ route('dokumen.destroy', $data->id) }}" method="post">
                        @csrf
                        <a href="{{ route('dokumen.edit', $data->id) }}" class="btn btn-sm btn-icon icon-left btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-icon icon-left btn-danger btn-sm" onClick="return confirm('Apakah data akan dihapus?')"><i class="fas fa-trash"></i> </button>
                    </form>
                </td>              
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="pagination text-left">Jumlah Data = {{ $jumlahdata }}</div>
    <div class="pagination justify-content-center">{{ $datadokumen->links() }}</div>
@endif
@endsection

@push('page-script')

@endpush