@extends('adminlte::page')

@section('title', 'Tambah / Edit Dokter')

@section('content_header')
    <h1>Tambah / Edit Dokter</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- CARD UNTUK FORM TAMBAH DATA --}}
    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Form Tambah Dokter</h3></div>
        <form action="{{ route('admin.dokter.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Dokter</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama dokter" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" value="{{ old('no_hp') }}" required>
                </div>
                <div class="form-group">
                    <label for="poli_id">Poli</label>
                    <select class="form-control" name="poli_id" id="poli_id">
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Field NIK dan Password sudah dihapus dari sini --}}
                {{-- Kita tetap perlu mengirim email, jadi kita buat tersembunyi --}}
                <input type="hidden" name="email" value="dokter.{{ time() }}@klinik.com">
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>

    {{-- CARD UNTUK TABEL DAFTAR DOKTER (Tidak ada perubahan) --}}
    <div class="card">
        <div class="card-header"><h3 class="card-title">Dokter</h3></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead><tr><th>No</th><th>Nama</th><th>Alamat</th><th>No. Hp</th><th>Poli</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($dokters as $dokter)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dokter->name }}</td>
                            <td>{{ $dokter->alamat }}</td>
                            <td>{{ $dokter->no_hp }}</td>
                            <td>{{ $dokter->poli->nama_poli ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" class="d-inline">
                                    <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada data dokter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
