@extends('adminlte::page')

@section('title', 'Edit Periksa Pasien')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary fw-bold mb-0">
            <i class="fas fa-user-md me-2"></i> Edit Pemeriksaan
        </h1>
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.periksa.index') }}">Daftar Periksa</a></li>
            <li class="breadcrumb-item active">Edit Periksa</li>
        </ol>
    </div>
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title fw-bold"><i class="fas fa-user-edit me-2"></i>Edit Periksa</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dokter.periksa.update', $periksa->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Pasien --}}
            <div class="mb-3">
                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                <input type="text" id="nama_pasien" class="form-control bg-light" value="{{ $periksa->pasien->name ?? 'N/A' }}" readonly>
            </div>

            {{-- Tanggal Periksa --}}
            <div class="mb-3">
                <label for="tgl_periksa" class="form-label">Tanggal Periksa</label>
                <input type="text" id="tgl_periksa" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d F Y H:i') }}" readonly>
            </div>

            {{-- Catatan --}}
            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea id="catatan" name="catatan" class="form-control" rows="4" placeholder="Masukkan catatan pemeriksaan dan diagnosa..." required>{{ old('catatan', $periksa->catatan) }}</textarea>
            </div>

            {{-- Obat --}}
            <div class="mb-3">
                <label for="obat_select" class="form-label">Obat</label>
                <select name="obat_id[]" id="obat_select" class="form-control" multiple>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}"
                            {{ in_array($obat->id, $selectedObatIds) ? 'selected' : '' }}>
                            {{ $obat->nama_obat }} - Rp.{{ number_format($obat->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Total Harga --}}
            <div class="mb-3">
                <label for="total_harga_obat" class="form-label">Total Harga Obat</label>
                <input type="number" id="total_harga_obat" name="total_harga_obat" class="form-control bg-light" readonly
                       value="{{ old('total_harga_obat', $periksa->total_harga_obat) }}">
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dokter.periksa.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"> </i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

    </div>
</div>
@stop

@push('js')
<script>
$(document).ready(function() {
    // ===============================================
    // == BAGIAN INI YANG MEMBUAT TAMPILAN BERUBAH   ==
    // ===============================================
    // Inisialisasi Select2 pada elemen select box obat
    $('#obat_select').select2({
        placeholder: "Pilih satu atau lebih obat",
        allowClear: true
    });

    const obats = @json($obats);

    function calculateTotal() {
        let grandTotal = 0;
        // Mengambil nilai yang dipilih dari Select2
        const selectedIds = $('#obat_select').val();
        
        if (selectedIds) {
            selectedIds.forEach(function(id) {
                const selectedObat = obats.find(obat => obat.id == id);
                if (selectedObat) {
                    grandTotal += selectedObat.harga;
                }
            });
        }
        $('#total_harga_obat').val(grandTotal);
    }

    // Hitung total saat halaman pertama kali dimuat
    calculateTotal(); 

    // Hitung ulang total setiap kali pilihan di Select2 berubah
    $('#obat_select').on('change', function() {
        calculateTotal();
    });
});
</script>
@endpush
