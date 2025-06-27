@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Dashboard Admin</h1>
@stop

@section('content')
<div class="container-fluid">
    {{-- Baris untuk Kartu Statistik --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            {{-- Kartu Jumlah Dokter --}}
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jumlahDokter ?? 0 }}</h3>
                    <p>Jumlah Dokter</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <a href="{{ route('admin.dokter.index') }}" class="small-box-footer">
                    Kelola Dokter <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu Jumlah Pasien --}}
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahPasien ?? 0 }}</h3>
                    <p>Jumlah Pasien</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <a href="{{ route('admin.pasien.index') }}" class="small-box-footer">
                    Kelola Pasien <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu Jumlah Poli --}}
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $jumlahPoli ?? 0 }}</h3>
                    <p>Jumlah Poli</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <a href="{{ route('admin.poli.index') }}" class="small-box-footer">
                    Kelola Poli <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            {{-- Kartu Jumlah Obat --}}
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $jumlahObat ?? 0 }}</h3>
                    <p>Jumlah Jenis Obat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pills"></i>
                </div>
                <a href="{{ route('admin.obat.index') }}" class="small-box-footer">
                    Kelola Obat <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Panel Administratif --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks mr-1"></i>
                        Panel Administratif
                    </h3>
                </div>
                <div class="card-body">
                    <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
                    <p>Anda telah login sebagai Administrator. Gunakan menu di samping untuk mengelola data dokter, pasien, dan data master lainnya dalam sistem.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop