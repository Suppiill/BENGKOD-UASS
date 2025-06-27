@extends('layouts.app') {{-- Pastikan ini sesuai dengan file layout utama Anda --}}

@section('subtitle', 'Profil Dokter')
@section('content_header_title', 'Profil Saya')
@section('content_header_subtitle', 'Lihat dan perbarui data diri Anda')

@section('content')
<div class="container-fluid">

    {{-- Notifikasi untuk pesan sukses setelah update --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Notifikasi untuk error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="font-weight-bold">Oops! Terjadi kesalahan.</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="row">
        <!-- Kolom Kiri: Informasi Profil -->
        <div class="col-md-5">
            <div class="card card-primary card-outline h-100">
                <div class="card-body box-profile">
                    <div class="text-center">
                        {{-- Avatar Inisial --}}
                        <div class="img-circle bg-primary d-flex justify-content-center align-items-center mx-auto" style="width: 100px; height: 100px;">
                            <span class="h1 text-white font-weight-bold">{{ substr($dokter->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <h3 class="profile-username text-center mt-3">{{ $dokter->name }}</h3>
                    <p class="text-muted text-center">{{ $dokter->spesialis ?? 'Spesialis belum diatur' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $dokter->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Bergabung Sejak</b> <a class="float-right">{{ $dokter->created_at->format('d M Y') }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('dokter.dashboard') }}" class="btn btn-primary btn-block"><b>Kembali ke Dashboard</b></a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Edit Profil -->
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header p-2">
                   <h5 class="mb-0 pt-1 pl-2 text-primary"><i class="fas fa-edit"></i> Edit Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('dokter.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $dokter->name) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="spesialis" class="col-sm-3 col-form-label">Spesialis</p></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="spesialis" name="spesialis" value="{{ old('spesialis', $dokter->spesialis) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $dokter->email) }}" required>
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted small">Kosongkan kolom password jika Anda tidak ingin mengubahnya.</p>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
