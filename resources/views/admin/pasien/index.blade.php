@extends('adminlte::page')

@section('title', 'Tambah / Edit Pasien')
@section('content_header')<h1>Tambah / Edit Pasien</h1>@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Berhasil!</h5>{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger"><strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Form Tambah Pasien</h3></div>
        <form action="{{ route('admin.pasien.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group"><label for="name">Nama Pasien</label><input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama pasien" value="{{ old('name') }}" required></div>
                <div class="form-group"><label for="alamat">Alamat</label><textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea></div>
                <div class="form-group"><label for="nik">Nomor KTP</label><input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan 16 digit NIK" value="{{ old('nik') }}" required></div>
                <div class="form-group"><label for="no_hp">Nomor HP</label><input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" value="{{ old('no_hp') }}" required></div>
                <div class="form-group"><label for="no_rm">Nomor RM</label><input type="text" class="form-control" id="no_rm" name="no_rm" value="Akan dibuat otomatis" readonly></div>
                {{-- Field Email dan Password sudah dihapus dari sini --}}
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>

    {{-- Tabel Daftar Pasien (Tidak ada perubahan) --}}
    <div class="card">
        <div class="card-header"><h3 class="card-title">Pasien</h3></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead><tr><th>No</th><th>Nama</th><th>Alamat</th><th>No. KTP</th><th>No. Hp</th><th>No. RM</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($pasiens as $pasien)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pasien->name }}</td>
                            <td>{{ $pasien->alamat }}</td>
                            <td>{{ $pasien->nik }}</td>
                            <td>{{ $pasien->no_hp }}</td>
                            <td>{{ $pasien->no_rm ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.pasien.destroy', $pasien->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" class="d-inline">
                                    <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-sm btn-success">Ubah</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Belum ada data pasien.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
