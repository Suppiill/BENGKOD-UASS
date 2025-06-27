@extends('adminlte::page')

@section('title', 'Profil Medis Lengkap')

@section('content_header')
    <h1>Profil Medis Lengkap</h1>
@stop

@section('content')
<div class="row">
    {{-- Kolom Kiri: Data Diri & Jadwal Mendatang --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/pasien-avatar.png') }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $pasien->name }}</h3>
                <p class="text-muted text-center">Pasien</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Email</b> <a class="float-right">{{ $pasien->email }}</a></li>
                    <li class="list-group-item"><b>No. HP</b> <a class="float-right">{{ $pasien->no_hp }}</a></li>
                    <li class="list-group-item"><b>Alamat</b> <span class="float-right">{{ $pasien->alamat }}</span></li>
                </ul>
            </div>
        </div>
        <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Jadwal Mendatang</h3></div>
            <div class="card-body">
                @forelse($jadwalOperasi as $jadwal)
                    <strong><i class="fas fa-calendar-alt mr-1"></i> {{ $jadwal->jenis_operasi }}</strong>
                    <p class="text-muted">
                        {{ \Carbon\Carbon::parse($jadwal->waktu_operasi)->format('d F Y, Pukul H:i') }}
                    </p>
                    @if(!$loop->last) <hr> @endif
                @empty
                    <p class="text-muted">Tidak ada jadwal mendatang.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Riwayat Pemeriksaan Terakhir --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ringkasan 5 Riwayat Pemeriksaan Terakhir</h3>
            </div>
            <div class="card-body">
                @if($riwayatPemeriksaan->isEmpty())
                    <p class="text-muted">Belum ada riwayat pemeriksaan.</p>
                @else
                    <div class="timeline">
                        @foreach ($riwayatPemeriksaan as $periksa)
                        <div>
                            <i class="fas fa-file-medical bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $periksa->tanggal_periksa->format('d M Y') }}</span>
                                <h3 class="timeline-header">
                                    Pemeriksaan oleh <strong>{{ $periksa->dokter->name ?? 'N/A' }}</strong>
                                </h3>
                                <div class="timeline-body">
                                    <p><strong>Diagnosis:</strong> {{ $periksa->diagnosis ?? 'Belum ada diagnosis' }}</p>
                                    <p class="mb-0"><strong>Keluhan Awal:</strong><br>{{ $periksa->keluhan }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="card-footer text-center">
                 <a href="{{ route('pasien.periksa.index') }}" class="btn btn-sm btn-primary">Lihat Semua Riwayat</a>
            </div>
        </div>
    </div>
</div>
@stop