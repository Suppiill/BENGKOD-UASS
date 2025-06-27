@extends('adminlte::page')

@section('title', 'Edit Poli')

@section('content_header')
    <h1>Edit Poli: {{ $poli->nama_poli }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Edit Poli</h3>
            </div>
            <form action="{{ route('admin.poli.update', $poli->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_poli">Nama Poli</label>
                        <input type="text" class="form-control" id="nama_poli" name="nama_poli" value="{{ old('nama_poli', $poli->nama_poli) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $poli->deskripsi) }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.poli.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
