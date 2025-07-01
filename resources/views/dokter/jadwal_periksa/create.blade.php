@extends('adminlte::page')

@section('title', 'Tambah Jadwal Periksa')

@section('content_header')
    <h1 class="text-primary fw-bold"><i class="fas fa-calendar-plus me-2"></i> Tambah Jadwal Periksa</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 shadow-sm">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-calendar-alt me-2"></i> Form Jadwal Baru
                </h5>
            </div>
            <div class="card-body bg-white rounded-bottom-4">
                <form action="{{ route('dokter.jadwal-periksa.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Hari --}}
                    <div class="form-group mb-3">
                        <label for="hari" class="form-label fw-semibold">Hari</label>
                        <select name="hari" id="hari" class="form-control border-primary" required>
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="form-group mb-3">
                        <label for="jam_mulai" class="form-label fw-semibold">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control border-primary" value="{{ old('jam_mulai') }}" required>
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="form-group mb-4">
                        <label for="jam_selesai" class="form-label fw-semibold">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control border-primary" value="{{ old('jam_selesai') }}" required>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        <a href="{{ route('dokter.jadwal-periksa.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--classic .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px;
            font-size: 1rem;
            border: 1px solid #0d6efd;
            border-radius: 0.375rem;
        }
        .select2-container--classic.select2-container--open .select2-selection--single {
            border-color: #0d6efd;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#hari').select2({
                placeholder: "-- Pilih Hari --",
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });
        });
    </script>
@endpush
