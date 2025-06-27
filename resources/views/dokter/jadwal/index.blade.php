@extends('adminlte::page')

@section('title', 'Jadwal Operasi')

@section('content_header')
    <h1>Jadwal Operasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Daftar Semua Jadwal Operasi</h3>
        <a href="{{ route('dokter.jadwal.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal Baru
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Filter Anda di sini --}}

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Waktu Operasi</th>
                        <th>Pasien</th>
                        <th>Jenis Operasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwals as $jadwal)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($jadwal->waktu_operasi)->format('d M Y, H:i') }}</td>

                            {{-- 👇 PERUBAHAN PENTING DI SINI 👇 --}}
                            {{-- Cek dulu apakah relasi pasien ada, baru tampilkan namanya --}}
                            <td>{{ $jadwal->pasien ? $jadwal->pasien->name : 'Pasien Telah Dihapus' }}</td>

                            <td>{{ $jadwal->jenis_operasi }}</td>
                            <td><span class="badge bg-warning">{{ $jadwal->status }}</span></td>
                            <td>
                                <a href="{{ route('dokter.jadwal.edit', $jadwal->id) }}" class="btn btn-xs btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin membatalkan jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger">
                                        <i class="fas fa-trash"></i> Batalkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada jadwal operasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop