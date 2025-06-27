{{-- resources/views/pasien/riwayat/show.blade.php --}}

@extends('layouts.app') {{-- Ganti ini sesuai nama layout Anda --}}

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Pemeriksaan - {{ $janjiTemu->tanggal_janji->format('d F Y') }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Dokter:</strong> {{ $janjiTemu->dokter->name }}</p>
            <p><strong>Pasien:</strong> {{ $janjiTemu->pasien->name }}</p>
            <hr>
            
            <h4>Keluhan Awal</h4>
            <p>{{ $janjiTemu->keluhan }}</p>
            <hr>

            {{-- Pastikan data pemeriksaan ada sebelum ditampilkan --}}
            @if ($janjiTemu->periksa)
                <h4>Hasil Diagnosa</h4>
                <p>{{ $janjiTemu->periksa->diagnosa }}</p>
                
                <h4>Catatan dari Dokter</h4>
                <p>{{ $janjiTemu->periksa->catatan ?: '-' }}</p>
                <hr>

                <h4>Resep Obat</h4>
                @if ($janjiTemu->periksa->detailPeriksa->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($janjiTemu->periksa->detailPeriksa as $resep)
                            <li class="list-group-item">
                                {{ $resep->obat->nama_obat }} - {{ $resep->jumlah }} {{ $resep->obat->satuan }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Tidak ada resep obat.</p>
                @endif
            @else
                <p class="text-muted">Detail hasil pemeriksaan belum tersedia.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-secondary">Kembali ke Riwayat</a>
            </div>
        </div>
    </div>
</div>
@endsection