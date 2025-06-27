@extends('adminlte::page')

@section('title', 'Obat')

@section('content_header')
    <h1>Obat</h1>
@stop

@section('content')
    {{-- Notifikasi untuk menampilkan pesan sukses atau error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- CARD UNTUK FORM TAMBAH OBAT --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Obat</h3>
        </div>
        {{-- Form ini akan mengirim data ke method 'store' di ObatController --}}
        <form action="{{ route('admin.obat.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" class="form-control" id="nama_obat" name="nama_obat" placeholder="Masukkan nama obat" value="{{ old('nama_obat') }}" required>
                </div>
                <div class="form-group">
                    <label for="kemasan">Kemasan</label>
                    <input type="text" class="form-control" id="kemasan" name="kemasan" placeholder="Contoh: 10 tablet / strip" value="{{ old('kemasan') }}" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga (hanya angka)" value="{{ old('harga') }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    {{-- CARD UNTUK TABEL DAFTAR OBAT --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Obat</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama obat</th>
                        <th>Kemasan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Di sini kita menggunakan variabel $obats (jamak) yang benar --}}
                    @forelse ($obats as $obat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->kemasan }}</td>
                            <td>Rp. {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');" class="d-inline">
                                    <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-sm btn-success">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
