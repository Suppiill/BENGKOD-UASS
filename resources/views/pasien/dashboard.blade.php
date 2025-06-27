@extends('adminlte::page')

@section('title', 'Dashboard Pasien')

@section('content_header')
    <h1>Dashboard Saya</h1>
    <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}!</p>
@stop

@section('content')
<div class="container-fluid">
    {{-- Baris Kartu Statistik --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jumlahRiwayat ?? 0 }}</h3>
                    <p>Total Riwayat Periksa</p>
                </div>
                <div class="icon"><i class="fas fa-history"></i></div>
                {{-- INI BAGIAN YANG DIPERBAIKI: Menggunakan nama route yang baru --}}
                <a href="{{ route('pasien.riwayat.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahResep ?? 0 }}</h3>
                    <p>Total Resep Diterima</p>
                </div>
                <div class="icon"><i class="fas fa-pills"></i></div>
                <a href="{{ route('pasien.obat.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- Sisa kartu statistik lain tidak diubah --}}
    </div>

    {{-- Panel Aksi Utama --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Butuh Bantuan Medis?</h5>
                    <p class="card-text">
                        Daftar ke poli tujuan Anda untuk membuat jadwal pemeriksaan dengan dokter.
                    </p>
                    <a href="{{ route('pasien.poli.daftar') }}" class="btn btn-primary">
                        <i class="fas fa-notes-medical"></i> Daftar Poli Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
