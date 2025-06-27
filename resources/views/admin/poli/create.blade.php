@extends('adminlte::page')
@section('title', 'Tambah Poli')
@section('content_header')
    <h1>Tambah Poli Baru</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.poli.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Poli</label>
                <input type="text" name="nama_poli" class="form-control @error('nama_poli') is-invalid @enderror" required>
                @error('nama_poli')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Deskripsi (Opsional)</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop