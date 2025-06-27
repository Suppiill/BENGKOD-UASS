@extends('adminlte::page')
@section('title', 'Tambah Dokter')
@section('content_header')
    <h1>Tambah Dokter Baru</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.dokter.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="Masukkan NIK 16 Digit" value="{{ old('nik') }}" required>

                @error('nik')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
             <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required>
                @error('alamat')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
             <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required>
                @error('no_hp')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@stop