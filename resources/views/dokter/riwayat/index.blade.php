@extends('adminlte::page')

@section('title', 'Riwayat Pasien')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary fw-bold"><i class="fas fa-history me-2"></i> Riwayat Pasien</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Riwayat</li>
        </ol>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-notes-medical me-2"></i> Daftar Pemeriksaan yang Telah Selesai
                </h5>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Periksa</th>
                                <th>Pasien</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatPeriksa as $periksa)
                                @php
                                    $obatList = $periksa->detail->map(fn($d) => $d->obat->nama_obat ?? 'Obat tidak ditemukan');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $periksa->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>{{ $periksa->pasien->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($periksa->catatan, 50, '...') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" data-toggle="modal"
                                            data-target="#detailModal"
                                            data-pasien-nama="{{ $periksa->pasien->name ?? 'N/A' }}"
                                            data-tanggal="{{ $periksa->created_at->format('d-m-Y H:i') }}"
                                            data-keluhan="{{ $periksa->keluhan }}"
                                            data-catatan="{{ $periksa->catatan }}"
                                            data-obat='@json($obatList)'
                                            data-biaya="Rp{{ number_format($periksa->total_harga_obat, 0, ',', '.') }}">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-1"></i> Belum ada riwayat pemeriksaan yang selesai.
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Riwayat Pemeriksaan</h5>
                <button type="button" class="btn-close bg-light" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-white">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th style="width: 200px;">Tanggal Periksa</th>
                        <td id="modal-tanggal"></td>
                    </tr>
                    <tr>
                        <th>Nama Pasien</th>
                        <td id="modal-pasien-nama"></td>
                    </tr>
                    <tr>
                        <th>Keluhan Awal</th>
                        <td id="modal-keluhan"></td>
                    </tr>
                    <tr>
                        <th>Catatan Dokter</th>
                        <td id="modal-catatan"></td>
                    </tr>
                    <tr>
                        <th>Resep Obat</th>
                        <td id="modal-obat"></td>
                    </tr>
                    <tr>
                        <th>Total Biaya Obat</th>
                        <td id="modal-biaya" class="fw-semibold text-success"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#detailModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);

            const pasienNama = button.data('pasien-nama');
            const tanggal = button.data('tanggal');
            const keluhan = button.data('keluhan');
            const catatan = button.data('catatan');
            const biaya = button.data('biaya');
            const obatList = button.data('obat');

            const obatHtml = (Array.isArray(obatList) && obatList.length > 0)
                ? '<ul class="mb-0 ps-3">' + obatList.map(obat => `<li>${obat}</li>`).join('') + '</ul>'
                : '<em>-</em>';

            const modal = $(this);
            modal.find('#modal-tanggal').text(tanggal);
            modal.find('#modal-pasien-nama').text(pasienNama);
            modal.find('#modal-keluhan').text(keluhan);
            modal.find('#modal-catatan').text(catatan);
            modal.find('#modal-obat').html(obatHtml);
            modal.find('#modal-biaya').text(biaya);
        });
    });
</script>
@stop
