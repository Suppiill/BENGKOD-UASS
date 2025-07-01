@extends('layouts.app')

@section('title', 'Periksa Pasien')

@@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="text-primary fw-bold mb-2 mb-md-0">
            <i class="fas fa-user-md me-2"></i> Periksa Pasien
        </h1>
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.periksa.index') }}">Daftar Periksa</a></li>
            <li class="breadcrumb-item active">Periksa Pasien</li>
        </ol>
    </div>
@stop


@section('content')
<form action="{{ route('dokter.periksa.store', $periksa->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-12">

            {{-- KARTU DETAIL PASIEN --}}
            <div class="card border-0 shadow rounded-4 mb-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-notes-medical me-2"></i> Detail Pasien & Diagnosa
                    </h5>
                </div>
                <div class="card-body bg-light">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold">Nama Pasien</label>
                            <input type="text" class="form-control border-primary" value="{{ $periksa->pasien->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold">Keluhan Utama</label>
                            <input type="text" class="form-control border-primary" value="{{ $periksa->keluhan }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="catatan" class="fw-semibold">Catatan / Diagnosa</label>
                        <textarea id="catatan" name="catatan" class="form-control border-primary" rows="4" placeholder="Masukkan catatan hasil pemeriksaan..." required>{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- KARTU RESEP OBAT --}}
            <div class="card border-0 shadow rounded-4 mb-4">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-pills me-2"></i> Resep Obat
                    </h5>
                </div>
                <div class="card-body bg-light">
                    <div id="resep-obat-container"></div>
                    <button type="button" id="tambah-obat" class="btn btn-success mt-2">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Obat
                    </button>
                </div>
            </div>

            {{-- KARTU BIAYA --}}
            <div class="card border-0 shadow rounded-4 mb-4">
                <div class="card-header bg-warning text-dark rounded-top-4">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-money-bill-wave me-2"></i> Total Biaya Obat
                    </h5>
                </div>
                <div class="card-body bg-light">
                    <div class="form-group">
                        <label class="fw-semibold">Total Harga Obat</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" id="total_harga_obat" name="total_harga_obat" class="form-control border-warning" value="0" readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('dokter.periksa.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Pemeriksaan
                </button>
            </div>

        </div>
    </div>
</form>
@stop

@push('js')
<script>
$(document).ready(function() {
    let resepCounter = 0;
    const obats = @json($obats);

    function calculateTotal() {
        let grandTotal = 0;
        $('.resep-row').each(function() {
            const obatId = $(this).find('.obat-select').val();
            const quantity = $(this).find('.obat-quantity').val();

            if (obatId && quantity > 0) {
                const selectedObat = obats.find(obat => obat.id == obatId);
                if (selectedObat) {
                    grandTotal += selectedObat.harga * quantity;
                }
            }
        });
        $('#total_harga_obat').val(grandTotal);
    }

    $('#tambah-obat').on('click', function() {
        resepCounter++;

        let obatOptions = '<option value="">-- Pilih Obat --</option>';
        obats.forEach(function(obat) {
            obatOptions += `<option value="${obat.id}">${obat.nama_obat} (Rp ${obat.harga})</option>`;
        });

        const newRow = `
            <div class="row resep-row mb-2 align-items-end" id="resep-row-${resepCounter}">
                <div class="col-md-7">
                    <label class="fw-semibold">Nama Obat</label>
                    <select name="obat_id[]" class="form-control obat-select" required>
                        ${obatOptions}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control obat-quantity" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-block hapus-resep mt-4" data-row-id="${resepCounter}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#resep-obat-container').append(newRow);
    });

    $(document).on('change', '.obat-select, .obat-quantity', calculateTotal);

    $(document).on('click', '.hapus-resep', function() {
        const rowId = $(this).data('row-id');
        $('#resep-row-' + rowId).remove();
        calculateTotal();
    });
});
</script>
@endpush
