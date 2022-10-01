@extends('layouts.admin-master')

@section('title', 'Dashboard')

@section('breadcumb')
<ol class="breadcrumb float-right">
    <li class="breadcrumb-item active">Aplikasi Ujian Dinas dan Ujian Penyesuaian Kenaikan Pangkat Pemerintah Daerah Provinsi Jawa Barat</li>
</ol>
@endsection

@section('content')
@if (Session::has ('pesan'))
<div class="alert alert-warning bg-warning text-white alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ Session::get('pesan') }}</strong>
</div>   
@endif
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary mini-stat position-relative">
            <div class="card-body">
                <div class="mini-stat-desc">
                    <h5 class="text-uppercase verti-label font-size-16 text-white-50">
                    </h5>
                    <div class="text-white">
                        <h5 class="text-uppercase font-size-16 text-white-50">Pengajuan</h5>
                        <h3 class="mb-3 text-white">{{ $totalusulan }}</h3>
                        <div class="">
                            <span class="badge bg-light text-info"> {{ $totalusulan }} </span> <span class="ms-2">From previous period</span>
                        </div>
                    </div>
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline display-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary mini-stat position-relative">
            <div class="card-body">
                <div class="mini-stat-desc">
                    <h5 class="text-uppercase verti-label font-size-16 text-white-50">
                    </h5>
                    <div class="text-white">
                        <h5 class="text-uppercase font-size-16 text-white-50">Baru</h5>
                        <h3 class="mb-3 text-white">{{ $usulanbaru }}</h3>
                        <div class="">
                            <span class="badge bg-light text-danger"> -29% </span> <span class="ms-2">From previous period</span>
                        </div>
                    </div>
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-buffer display-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary mini-stat position-relative">
            <div class="card-body">
                <div class="mini-stat-desc">
                    <h5 class="text-uppercase verti-label font-size-16 text-white-50">
                    </h5>
                    <div class="text-white">
                        <h5 class="text-uppercase font-size-16 text-white-50">Verifikasi
                        </h5>
                        <h3 class="mb-3 text-white">{{ $usulanver }}</h3>
                        <div class="">
                            <span class="badge bg-light text-primary"> 0% </span> <span class="ms-2">From previous period</span>
                        </div>
                    </div>
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-tag-text-outline display-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary mini-stat position-relative">
            <div class="card-body">
                <div class="mini-stat-desc">
                    <h5 class="text-uppercase verti-label font-size-16 text-white-50">
                    </h5>
                    <div class="text-white">
                        <h5 class="text-uppercase font-size-16 text-white-50">Disetujui
                        </h5>
                        <h3 class="mb-3 text-white">{{ $usulanacc }}</h3>
                        <div class="">
                            <span class="badge bg-light text-info"> +89% </span> <span class="ms-2">From previous period</span>
                        </div>
                    </div>
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-briefcase-check display-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Col -->
</div>
@endsection