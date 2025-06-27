@extends('adminlte::page')

@section('title', 'Edit Obat')

@section('content_header')
    <h1>Edit Obat: {{ $obat->nama_obat }}</h1>
@stop

@section('content')
    {{-- Notifikasi untuk menampilkan error validasi --}}
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

    {{-- Kartu untuk Form Edit --}}
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Form Edit Obat</h3>
        </div>
        {{-- Form ini akan mengarah ke method 'update' di ObatController --}}
        <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Metode PUT wajib untuk proses update --}}
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                </div>
                <div class="form-group">
                    <label for="kemasan">Kemasan</label>
                    {{-- Diubah menjadi input teks biasa agar sesuai dengan form tambah --}}
                    <input type="text" class="form-control" id="kemasan" name="kemasan" value="{{ old('kemasan', $obat->kemasan) }}" placeholder="Contoh: 10 tablet / strip" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $obat->harga) }}" placeholder="Masukkan harga (hanya angka)" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
