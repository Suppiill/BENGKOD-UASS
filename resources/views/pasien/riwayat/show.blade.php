@extends('adminlte::page')

@section('title', 'Detail Riwayat Pemeriksaan')

@section('content_header')
    <h1>Detail Riwayat Pemeriksaan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pasien.riwayat.index') }}">Riwayat</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                {{-- PERBAIKAN: Menggunakan variabel $periksa, bukan $janjiTemu --}}
                <h3 class="card-title">Detail Pemeriksaan - {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d F Y') }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Pasien</th>
                        {{-- Menggunakan relasi untuk mengambil nama pasien --}}
                        <td>{{ $periksa->pasien->name }}</td>
                    </tr>
                    <tr>
                        <th>Dokter</th>
                        <td>{{ $periksa->dokter->name }}</td>
                    </tr>
                    <tr>
                        <th>Poli</th>
                        <td>{{ $periksa->jadwal?->poli?->nama_poli ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Keluhan Utama</th>
                        <td>{{ $periksa->keluhan }}</td>
                    </tr>
                     <tr>
                        <th>Catatan / Diagnosa</th>
                        <td>{{ $periksa->catatan }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Resep Obat</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop melalui detail resep yang sudah di-load di controller --}}
                        @forelse ($periksa->detail as $item)
                            <tr>
                                <td>{{ $item->obat->nama_obat }}</td>
                                <td>{{ $item->jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada resep obat untuk pemeriksaan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                 <hr>
                <strong>Total Biaya Obat:</strong>
                <h4 class="float-right">Rp {{ number_format($periksa->total_harga_obat, 0, ',', '.') }}</h4>
            </div>
            <div class="card-footer">
                <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@stop
