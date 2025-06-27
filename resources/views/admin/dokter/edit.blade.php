@extends('adminlte::page')

@section('title', 'Edit Dokter')

@section('content_header')
    <h1>Edit Data Dokter: {{ $dokter->name }}</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Form Edit Dokter</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Dokter</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $dokter->name) }}" required>
                </div>
                 <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $dokter->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $dokter->alamat) }}</textarea>
                </div>
                 <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" required>
                </div>
                <div class="form-group">
                    <label for="poli_id">Poli</label>
                    <select class="form-control" name="poli_id" id="poli_id">
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}" {{ $dokter->poli_id == $poli->id ? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>
                 {{-- Field NIK dan Password sudah dihapus dari tampilan edit --}}
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-default">Batal</a>
            </div>
        </div>
    </form>
@stop
