@extends('layouts.admin-master')

@section('title', 'Surat Pengantar')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Fasilitator</a></li>
    <li class="breadcrumb-item active">Surat pengantar</a></li>
</ol>
@endsection

@section('content')
{{-- {{ $id }} --}}
@if (Session::has ('pesan'))
<div class="alert alert-success bg-success text-white alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ Session::get('pesan') }}</strong>
</div>   
@endif
@if (Session::has ('gagal'))
<div class="alert alert-warning bg-warning text-white alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ Session::get('gagal') }}</strong>
</div>   
@endif

<div class="row">
    <div class="col-md-6">
        <div class="pull-right" role="toolbar">
            <a href="{{ route('pengantar.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah Pengantar</a>
        </div>            
    </div>
    <div class="col-md-6"> 
    </div>
</div>
<br>

@if ($jumlahpengantar === 0 )
{{--     <div class="alert alert-danger bg-danger text-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Surat pengatar belum dibuat..</strong>
    </div>  --}}
@else

    <div class="table-responsive b-0" data-pattern="priority-columns">
        <table class="table table-sm table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;">No</th>
                    <th  style="width: 20%;">
                        Nomor Surat
                    </th>
                    <th style="width: 15%;">
                        Tanggal Surat
                    </th>
                    <th style="width: 35%;">
                        Perihal Surat
                    </th>
    {{--                 <th style="width: 10%;">
                        Jumlah Usulan
                    </th> --}}
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
        <body>
            @foreach ($datapengantar as $data )                   
            <tr>
                <td class="text-center">{{ ++$no }}</td>
                <td>{{ $data->nomor }}</td>  
                <td class="text-center">{{$data->tanggal->format('d-m-Y')}}</td>  
                <td>{{ $data->perihal }}</td>  
    {{--             <td class="text-center">{{ $hitungusulan }}</td>   --}}
                <td class="text-center">
                    <form action="{{ route('pengantar.destroy', $data->id) }}" method="post">
                        @csrf
                        <a href="{{ route('pengantar.view', $data->id) }}" class="btn btn-icon icon-left btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Detil"><i class="fas fa-search"></i></a>

                        <a href="{{ route('pengantar.edit', $data->id) }}" class="btn btn-icon icon-left btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit pengantar"><i class="fas fa-edit"></i></a>

                        <button class="btn btn-icon icon-left btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Hapus pengantar" onClick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i></button>
                    <input type="hidden" name="file" value="{{ $data->file }}">
                </form>
    {{--                 <form action="{{ route('pendaftaran.destroy', $data->id) }}" method="post">
                    @csrf
                        <a href="{{ route('pendaftaran.view', $data->id) }}" class="btn btn-icon icon-left btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Lihat Usulan"><i class="fas fa-search"></i></a>

                        <button class="btn btn-icon icon-left btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Hapus usulan" onClick="return confirm('Yakin mau dihapus?')" disabled><i class="fas fa-trash"></i></button>
                        <input type="hidden" name="nip" value="{{ $data->nip }}">
                    </form>
                    @else
                    <form action="{{ route('pendaftaran.destroy', $data->id) }}" method="post">
                    @csrf
                        <a href="{{ route('pendaftaran.view', $data->id) }}" class="btn btn-icon icon-left btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="unggah dokumen"><i class="fas fa-folder-open"></i></a>

                        <button class="btn btn-icon icon-left btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="batalkan usulan" onClick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i></button>
                        <input type="hidden" name="nip" value="{{ $data->nip }}">
                    </form>
                    @endif  --}}
                </td>              
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>

@endif

@endsection


@push('page-script')

@endpush