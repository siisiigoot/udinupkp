@extends('layouts.login-master')

@section('content')
<div class="card">
    <div class="card-body">
        <h3 class="text-center m-0">
            <a href="#" class="logo logo-admin"><img src="{{ asset('assets/images/logo-jabar.png') }}" alt="logo" height="128"></a>
        </h3>

        <div class="p-3">
            <h4 class="text-muted font-16 m-b-5 text-center">Ujian Dinas dan Ujian Penyesuaian Kenaikan Pangkat</h4>
            <p class="text-muted text-center">Pemerintah Daerah Provinsi Jawa Barat</p>

            <form method="POST" action="{{ route('login') }}">
               @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                    
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-6">
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Login</button>
                    </div>
                </div>

{{--                 <div class="form-group m-t-10 mb-0 row">
                    <div class="col-12 m-t-20">
                        <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                    </div>
                </div> --}}
            </form>
        </div>

    </div>
</div>

<div class="m-t-40 text-center">
    <span class="d-none d-sm-inline-block">UdinUPKP © 2021 - Kepangkatan Juara <i class="mdi mdi-heart text-danger"></i></span>
</div>

@endsection
