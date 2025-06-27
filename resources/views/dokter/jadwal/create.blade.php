@extends('adminlte::page')

@section('title', 'Tambah Jadwal Operasi')

@section('content_header')
    <h1>Tambah Jadwal Operasi Baru</h1>
@stop

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">Formulir Jadwal Operasi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dokter.jadwal.store') }}" method="POST">
            @csrf
            
            {{-- Field Pilih Pasien --}}
            <div class="form-group">
                <label for="pasien_id">Pilih Pasien</label>
                <select name="pasien_id" id="pasien_id" class="form-control @error('pasien_id') is-invalid @enderror">
                    <option value="">-- Pilih Salah Satu --</option>
                    @foreach ($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>{{ $pasien->name }}</option>
                    @endforeach
                </select>
                @error('pasien_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Field Jenis Operasi --}}
            <div class="form-group">
                <label for="jenis_operasi">Jenis Operasi</label>
                <input type="text" name="jenis_operasi" class="form-control @error('jenis_operasi') is-invalid @enderror" 
                       id="jenis_operasi" placeholder="Contoh: Operasi Caesar" value="{{ old('jenis_operasi') }}">
                @error('jenis_operasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Field Waktu Operasi --}}
            <div class="form-group">
                <label for="waktu_operasi">Waktu Operasi</label>
                <input type="datetime-local" name="waktu_operasi" class="form-control @error('waktu_operasi') is-invalid @enderror" 
                       id="waktu_operasi" value="{{ old('waktu_operasi') }}">
                @error('waktu_operasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Field Ruang Operasi --}}
            <div class="form-group">
                <label for="ruang_operasi">Ruang Operasi</label>
                <input type="text" name="ruang_operasi" class="form-control @error('ruang_operasi') is-invalid @enderror" 
                       id="ruang_operasi" placeholder="Contoh: Ruang Operasi 1" value="{{ old('ruang_operasi') }}">
                @error('ruang_operasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Field Catatan (Opsional) --}}
            <div class="form-group">
                <label for="catatan">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" id="catatan" class="form-control">{{ old('catatan') }}</textarea>
            </div>
            
            <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
        </form>
    </div>
</div>
@stop