{{-- resources/views/pasien/riwayat/index.blade.php --}}

{{-- Gunakan layout utama Anda --}}
@extends('layouts.app') {{-- Ganti ini sesuai nama layout Anda --}}

@section('content')
<div class="container">
    <h1>Riwayat Janji Temu Saya</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal Janji</th>
                <th>Dokter</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayatJanjiTemu as $janji)
                <tr>
                    <td>{{ $janji->tanggal_janji->format('d F Y') }}</td>
                    <td>{{ $janji->dokter->name }}</td>
                    <td>
                        @php
                            $status = $janji->status->value;
                            $badgeClass = '';
                            switch ($status) {
                                case 'diterima': $badgeClass = 'badge bg-primary'; break;
                                case 'selesai': $badgeClass = 'badge bg-success'; break;
                                case 'ditolak': $badgeClass = 'badge bg-danger'; break;
                                default: $badgeClass = 'badge bg-warning text-dark'; break;
                            }
                        @endphp
                        <span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                    </td>
                    <td>
                        @if ($janji->status->value == 'selesai' && $janji->periksa)
                            <a href="{{ route('pasien.riwayat.show', $janji->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Anda belum memiliki riwayat janji temu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Tambahkan sedikit style untuk badge jika belum ada --}}
<style>
    .badge { display: inline-block; padding: .35em .65em; font-size: .75em; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25rem; }
    .bg-primary { color: #fff; background-color: #0d6efd; }
    .bg-success { color: #fff; background-color: #198754; }
    .bg-danger { color: #fff; background-color: #dc3545; }
    .bg-warning { color: #000; background-color: #ffc107; }
</style>
@endsection