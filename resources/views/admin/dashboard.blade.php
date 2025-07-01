@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1 class="fw-bold text-primary"><i class="fas fa-tools me-2"></i>Dashboard Admin</h1>
@stop

@section('content')
<div class="container-fluid">
    {{-- Ucapan Selamat Berdasarkan Waktu --}}
@php
    $hour = now()->format('H');
    $greeting = 'Selamat datang';

    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Selamat pagi';
    } elseif ($hour >= 12 && $hour < 15) {
        $greeting = 'Selamat siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat sore';
    } else {
        $greeting = 'Selamat malam';
    }
@endphp

<div class="alert alert-primary d-flex align-items-center justify-content-between shadow-sm rounded-3">
    <div>
        <h5 class="mb-0 fw-bold">{{ $greeting }}, {{ Auth::user()->name }} 👋</h5>
        <small>Semoga harimu menyenangkan dan tetap produktif dalam mengelola data klinik.</small>
    </div>
    <div class="d-none d-md-block">
        <i class="fas fa-clock fa-2x text-primary"></i>
    </div>
</div>


    {{-- KARTU STATISTIK --}}
    <div class="row g-4 mt-2">
        {{-- Dokter --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow rounded-4 bg-gradient-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0">{{ $jumlahDokter ?? 0 }}</h5>
                        <small>Jumlah Dokter</small>
                    </div>
                    <i class="fas fa-user-md fa-2x opacity-75"></i>
                </div>
                <div class="card-footer border-0 bg-transparent text-white text-end">
                    <a href="{{ route('admin.dokter.index') }}" class="text-white small text-decoration-none">
                        Kelola Dokter <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Pasien --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow rounded-4 bg-gradient-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0">{{ $jumlahPasien ?? 0 }}</h5>
                        <small>Jumlah Pasien</small>
                    </div>
                    <i class="fas fa-user-injured fa-2x opacity-75"></i>
                </div>
                <div class="card-footer border-0 bg-transparent text-white text-end">
                    <a href="{{ route('admin.pasien.index') }}" class="text-white small text-decoration-none">
                        Kelola Pasien <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Poli --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow rounded-4 bg-gradient-warning text-dark">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0">{{ $jumlahPoli ?? 0 }}</h5>
                        <small>Jumlah Poli</small>
                    </div>
                    <i class="fas fa-hospital fa-2x opacity-75"></i>
                </div>
                <div class="card-footer border-0 bg-transparent text-end">
                    <a href="{{ route('admin.poli.index') }}" class="text-dark small text-decoration-none">
                        Kelola Poli <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Obat --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow rounded-4 bg-gradient-danger text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0">{{ $jumlahObat ?? 0 }}</h5>
                        <small>Jumlah Jenis Obat</small>
                    </div>
                    <i class="fas fa-pills fa-2x opacity-75"></i>
                </div>
                <div class="card-footer border-0 bg-transparent text-white text-end">
                    <a href="{{ route('admin.obat.index') }}" class="text-white small text-decoration-none">
                        Kelola Obat <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- PANEL ADMIN --}}
    <div class="card mt-4 shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Panel Administrator</h5>
        </div>
        <div class="card-body">
            <h4 class="fw-bold text-primary">Selamat Datang, {{ Auth::user()->name }}!</h4>
            <p class="text-muted">Gunakan menu navigasi untuk mengelola data dokter, pasien, poli, dan obat. Pastikan data selalu terupdate agar sistem berjalan optimal.</p>
        </div>
    </div>

</div>
@stop
@push('css')
<style>
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745, #218838);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #dc3545, #bd2130);
    }
    .card-footer a:hover {
        text-decoration: underline;
    }
</style>
@endpush
