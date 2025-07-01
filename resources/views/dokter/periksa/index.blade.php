@extends('adminlte::page')

@section('title', 'Daftar Periksa Pasien')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="text-dark fw-bold mb-2 mb-md-0">
            <i class="fas fa-clipboard-list me-2 text-primary"></i> Daftar Periksa Pasien
        </h1>
    </div>
@stop


@section('content')
<div class="row">
    <div class="col-12">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <strong><i class="fas fa-check-circle me-1"></i>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-notes-medical me-1"></i> Antrean Pasien Hari Ini</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarPeriksa as $periksa)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $periksa->pasien->name ?? 'N/A' }}</td>
                                <td>{{ $periksa->keluhan }}</td>
                                <td>
                                    @if ($periksa->status == 'menunggu')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                    @else
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($periksa->status == 'menunggu')
                                        <a href="{{ route('dokter.periksa.mulai', $periksa->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-stethoscope me-1"></i> Periksa
                                        </a>
                                    @else
                                        <a href="{{ route('dokter.periksa.edit', $periksa->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada pasien yang menunggu saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@stop

@push('css')
    {{-- Ionicons --}}
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {{-- Tambahan gaya agar tabel lebih cantik --}}
    <style>
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .select2-container .select2-selection--multiple {
        border-radius: 0.375rem;
        border-color: #ced4da;
    }
</style>
@endpush
