@extends('adminlte::page')

@section('title', 'Jadwal Periksa')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Jadwal Periksa</h1>
        <a href="{{ route('dokter.jadwal-periksa.create') }}" class="btn btn-primary btn-sm shadow">
            <i class="fas fa-plus-circle me-1"></i> Tambah Jadwal
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-primary text-center align-middle">
                            <tr>
                                <th>No</th>
                                <th>Nama Dokter</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Status</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                            @forelse ($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jadwal->dokter->name ?? Auth::user()->name }}</td>
                                    <td>{{ $jadwal->hari }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $jadwal->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $jadwal->status ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('dokter.jadwal-periksa.edit', $jadwal->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit Jadwal">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwal->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Jadwal">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada jadwal periksa.</td>
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
