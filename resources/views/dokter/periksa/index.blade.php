@extends('adminlte::page')

@section('title', 'Daftar Periksa Pasien')

@section('content_header')
    <h1>Daftar Periksa Pasien</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No Urut</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarPeriksa as $janji)
                            <tr>
                                <td>{{ $janji->nomor_antrian ?? $loop->iteration }}</td>
                                <td>{{ $janji->pasien->name ?? 'Nama Pasien Tidak Ditemukan' }}</td>
                                <td>{{ $janji->keluhan }}</td>
                                <td>
                                    {{-- Tombol ini akan mengarah ke halaman form pemeriksaan --}}
                                    <a href="{{ route('dokter.periksa.mulai', $janji->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada pasien dalam daftar tunggu periksa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
