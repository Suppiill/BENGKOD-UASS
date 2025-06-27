{{-- Ganti dengan layout utama Anda --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Janji Temu Baru</h1>

    {{-- BAGIAN INI SANGAT PENTING UNTUK MENAMPILKAN ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pasien.janji-temu.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="dokter_id">Pilih Dokter</label>
            <select name="dokter_id" id="dokter_id" class="form-control" required>
                <option value="">-- Silakan Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                        {{ $dokter->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="tanggal_janji">Tanggal Janji</label>
            <input type="date" name="tanggal_janji" id="tanggal_janji" class="form-control" value="{{ old('tanggal_janji') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="waktu_janji">Waktu Janji (Contoh: 14:00)</label>
            <input type="time" name="waktu_janji" id="waktu_janji" class="form-control" value="{{ old('waktu_janji') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="keluhan">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control" rows="4" required>{{ old('keluhan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Buat Janji Temu</button>
    </form>
</div>
@endsection