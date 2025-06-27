@extends('adminlte::page')

@section('title', 'Resep Obat Saya')

@section('content_header')
    <h1>Daftar Resep Obat Saya</h1>
    <p class="text-muted">Daftar obat-obatan yang diresepkan oleh dokter untuk Anda.</p>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-gradient-success text-white">
                <h3 class="card-title mb-0"><i class="fas fa-pills mr-2"></i>Resep Obat</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Tanggal Resep</th>
                                <th scope="col">Nama Obat</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Aturan Pakai</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($resepObat as $resep)
                                <tr>
                                    <td>{{ $resep->created_at->format('d F Y') }}</td>
                                    <td>{{ $resep->obat->nama_obat }}</td>
                                    <td>{{ $resep->jumlah }}</td>
                                    <td>{{ $resep->aturan_pakai }}</td>
                                    <td>
                                        @if ($resep->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-muted mb-0">Tidak ada data resep obat untuk Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop