@extends('adminlte::page')

@section('title', 'Edit Periksa Pasien')

@section('content_header')
    <h1>Edit Periksa Pasien</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Periksa</h3>
    </div>
    <form action="{{ route('dokter.periksa.update', $periksa->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Nama Pasien</label>
                {{-- Menampilkan nama pasien dari relasi, dibuat readonly --}}
                <input type="text" class="form-control" value="{{ $periksa->pasien->name ?? 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Periksa</label>
                {{-- Menampilkan tanggal periksa, dibuat readonly --}}
                <input type="text" class="form-control" value="{{ $periksa->tgl_periksa->format('d M Y, H:i') }}" readonly>
            </div>
            <div class="form-group">
                <label for="catatan">Catatan</label>
                {{-- Dokter bisa mengedit catatan --}}
                <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $periksa->catatan) }}</textarea>
            </div>
             <div class="form-group">
                <label for="diagnosa">Diagnosa</label>
                {{-- Dokter bisa mengedit diagnosa --}}
                <input type="text" name="diagnosa" id="diagnosa" class="form-control" value="{{ old('diagnosa', $periksa->diagnosa) }}">
            </div>
            <div class="form-group">
                <label>Obat yang Diberikan</label>
                {{-- Menampilkan daftar obat yang sudah diberikan --}}
                <ul class="list-group">
                    @forelse ($periksa->detailPeriksa as $detail)
                        <li class="list-group-item">
                            {{ $detail->obat->nama_obat }} - {{ $detail->jumlah }} {{ $detail->obat->kemasan }}
                        </li>
                    @empty
                        <li class="list-group-item">Tidak ada resep obat.</li>
                    @endforelse
                </ul>
                {{-- Note: Logika untuk mengedit/menambah obat di halaman ini bisa ditambahkan jika perlu --}}
            </div>
            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" class="form-control" value="Rp {{ number_format($periksa->total_harga_obat, 0, ',', '.') }}" readonly>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dokter.riwayat.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@stop
