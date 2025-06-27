@extends('adminlte::page')

@section('title', 'Tambah Pasien')

@section('content_header')
    <h1>Tambah Pasien</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Form Tambah Pasien</div>
        <div class="card-body">
            <form action="{{ route('dokter.periksa.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pasien</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="keluhan" class="form-label">Keluhan</label>
                    <input type="text" name="keluhan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tindakan" class="form-label">Tindakan</label>
                    <input type="text" name="tindakan" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('dokter.periksa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
