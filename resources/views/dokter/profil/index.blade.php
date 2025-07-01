@extends('layouts.app')

@section('title', 'Profil Dokter')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="text-primary fw-bold mb-2">
            <i class="fas fa-user-md me-2"></i> Profil Dokter
        </h1>
    </div>
@stop

@section('content')
<div class="row">

    {{-- PANEL PROFIL KIRI --}}
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=150"
                     class="img-fluid rounded-circle mb-3" alt="Avatar Dokter">
                <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-1">
                    <i class="fas fa-envelope me-1"></i> {{ Auth::user()->email }}
                </p>
                @if(Auth::user()->no_hp)
                <p class="text-muted mb-1">
                    <i class="fas fa-phone me-1"></i> {{ Auth::user()->no_hp }}
                </p>
                @endif
                @if(Auth::user()->alamat)
                <p class="text-muted">
                    <i class="fas fa-map-marker-alt me-1"></i> {{ Auth::user()->alamat }}
                </p>
                @endif
                <hr>
                <span class="badge bg-success px-3 py-2">Role: Dokter</span>
            </div>
        </div>
    </div>

    {{-- FORM EDIT KANAN --}}
    <div class="col-md-8">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-times-circle me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-edit me-2"></i> Edit Informasi Profil
                </h5>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                <form action="{{ route('dokter.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Dokter</label>
                        <input type="text" class="form-control border-primary" id="name" name="name" required
                               value="{{ old('name', Auth::user()->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat Dokter</label>
                        <textarea id="alamat" name="alamat" class="form-control border-primary" rows="3"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="no_hp" class="form-label fw-semibold">Telepon Dokter</label>
                        <input type="text" id="no_hp" name="no_hp" class="form-control border-primary"
                               placeholder="081234567890" value="{{ old('no_hp', Auth::user()->no_hp) }}">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
