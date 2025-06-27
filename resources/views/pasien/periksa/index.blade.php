@extends('adminlte::page')

@section('title', 'Riwayat Pemeriksaan')

@section('content_header')
    <h1>Riwayat Pemeriksaan Saya</h1>
    <p class="text-muted">Semua catatan kunjungan dan hasil pemeriksaan Anda tersimpan di sini.</p>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-history mr-2"></i>Daftar Riwayat</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal Kunjungan</th>
                                <th scope="col">Dokter yang Memeriksa</th>
                                <th scope="col">Diagnosis Utama</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Gunakan @forelse untuk menampilkan data atau pesan jika kosong --}}
                            @forelse ($riwayatPemeriksaan as $pemeriksaan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pemeriksaan->created_at->format('d F Y') }}</td>
                                    <td>{{ $pemeriksaan->dokter->name }}</td>
                                    <td>{{ $pemeriksaan->diagnosis }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-muted mb-0">Anda belum memiliki riwayat pemeriksaan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop