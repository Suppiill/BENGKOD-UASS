@extends('adminlte::page')

@section('title', 'Form Pemeriksaan')

@section('content_header')
    <h1>Pemeriksaan Pasien: {{ $janjiTemu->pasien->name }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('dokter.periksa.store', $janjiTemu->id) }}" method="POST">
            @csrf
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Detail Pemeriksaan</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Keluhan Pasien</label>
                        <p class="form-control-static">{{ $janjiTemu->keluhan }}</p>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan Dokter</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Masukkan catatan hasil pemeriksaan..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="diagnosa">Diagnosa</label>
                        <input type="text" name="diagnosa" id="diagnosa" class="form-control" placeholder="Masukkan diagnosa penyakit" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Hasil Pemeriksaan</button>
                    <a href="{{ route('dokter.periksa.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
