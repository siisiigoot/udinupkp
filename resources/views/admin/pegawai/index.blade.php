@extends('layouts.admin-master')

@section('title', 'Pegawai')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
    <li class="breadcrumb-item active">Pegawai</a></li>
</ol>
@endsection

@section('content')
    <h4 class="mt-0 header-title">Daftar Pegawai</h4>
    <p class="text-muted m-b-30">{{ $namapd->pd->pd }} Provinsi Jawa Barat.
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
    <div class="row">
        <div class="col-md-6">
{{--             <div class="form-group row col-md-12">
                <label class="col-md-2 col-form-label">Filter :</label>
                <div class="col-md-10">
                    <select class="form-control select2" name="pd">
                        <option selected disabled>--Semua--</option>
                        @foreach($dataperangkatdaerah as $datapd)
                            <option value="{{$datapd->id}}">{{$datapd->pd}}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-md-4">
            <form action="{{ route('pegawai.search') }}" method="GET">
                @csrf
                <div class="input-group mb-3 pull-right">
                    <input type="text" class="form-control" placeholder="Cari NIP / Nama pegawai..." name="kata" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-icon icon-left btn-primary" type="submit"><i class="fas fa-search" id="button-addon2"></i> Cari Data</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive b-0" data-pattern="priority-columns">
        <table class="table table-sm table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Golongan</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Perangkat Daerah</th>
                    <th>Instansi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        <body>
            @foreach ($datapegawai as $data )                   
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $data->nip }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->jk }}</td>
                <td>{{ $data->gol }}</td>
                <td>{{ $data->jab }}</td>
                <td>{{ $data->unkerja }}</td>
                <td>{{ $data->pd }}</td>
                <td>{{ $data->instansi }}</td>     
                <td>
                    <a href="{{ route('pegawai.view', $data->id) }}" class="btn btn-sm btn-icon icon-left btn-primary"><i class="fas fa-search"></i></a>
                </td>              
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="pagination text-left">Jumlah Data = {{ $jumlahdata }}</div>
    <div class="pagination justify-content-center">{{ $datapegawai->appends(request()->except('page'))->links() }}</div>
    
@endsection

@push('page-script')

@endpush