@extends('adminlte::page')

@section('title', 'Edit Status Jadwal')

@section('content_header')
    <h1 class="text-primary fw-bold"><i class="fas fa-toggle-on me-2"></i> Edit Status Jadwal</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-6">
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 shadow-sm">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-calendar-alt me-2"></i> Informasi Jadwal
                </h5>
            </div>
            <form action="{{ route('dokter.jadwal-periksa.update', $jadwalPeriksa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body bg-white rounded-bottom-4">
                    {{-- Hari --}}
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Hari</label>
                        <input type="text" class="form-control" value="{{ $jadwalPeriksa->hari }}" readonly>
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Jam Mulai</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H:i') }}" readonly>
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">Jam Selesai</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H:i') }}" readonly>
                    </div>

                    <hr class="mb-4">

                    {{-- Ubah Status --}}
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">Ubah Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_aktif" value="1" {{ $jadwalPeriksa->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_aktif">Aktif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_tidak_aktif" value="0" {{ !$jadwalPeriksa->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_tidak_aktif">Tidak Aktif</label>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        <a href="{{ route('dokter.jadwal-periksa.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
