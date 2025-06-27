@extends('adminlte::auth.register')

@section('auth_body')
    <form action="{{ route('register') }}" method="post">
        @csrf

        {{-- Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Nama Lengkap" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="row mb-3">
            <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('NIK') }}</label>
            <div class="col-md-6">
                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" required>
                @error('nik')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Alamat field --}}
        <div class="input-group mb-3">
            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                   value="{{ old('alamat') }}" placeholder="Alamat" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-map-marker-alt"></span>
                </div>
            </div>
            @error('alamat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- No. HP field --}}
        <div class="input-group mb-3">
            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                   value="{{ old('no_hp') }}" placeholder="Nomor HP" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                </div>
            </div>
            @error('no_hp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Ketik ulang password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            Daftar
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            Saya sudah punya keanggotaan
        </a>
    </p>
@stop