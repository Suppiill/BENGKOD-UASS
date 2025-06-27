@extends('adminlte::page')

@section('title', 'Riwayat Pasien')

@section('content_header')
    <h1>Riwayat Pemeriksaan Pasien</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Semua Pemeriksaan Selesai</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Periksa</th>
                    <th>Nama Pasien</th>
                    <th>Diagnosa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatPeriksa as $periksa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $periksa->tgl_periksa->format('d M Y, H:i') }}</td>
                        <td>{{ $periksa->pasien->name ?? 'N/A' }}</td>
                        <td>{{ $periksa->diagnosa }}</td>
                        <td>
                            {{-- Tombol ini akan mengarah ke halaman detail/edit --}}
                            <a href="{{ route('dokter.periksa.edit', $periksa->id) }}" class="btn btn-sm btn-info">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada riwayat pemeriksaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
