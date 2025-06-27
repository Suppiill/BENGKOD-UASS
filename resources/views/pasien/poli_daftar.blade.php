@extends('adminlte::page')

@section('title', 'Daftar Poli')

@section('content_header')
    <h1>Daftar Poli</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Form Pendaftaran Poli</h3></div>
                
                <form action="{{ route('pasien.poli.store') }}" method="POST"> 
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nomor Rekam Medis</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->no_rm ?? 'Belum Ada' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="id_poli">Pilih Poli</label>
                            <select class="form-control" id="id_poli" name="id_poli" required>
                                <option value="">-- Pilih Poli --</option>
                                @foreach($daftar_poli as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_jadwal">Pilih Jadwal</label>
                            <select class="form-control" id="id_jadwal" name="id_jadwal" required>
                                <option value="">-- Pilih Poli terlebih dahulu --</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="keluhan">Keluhan</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="4" placeholder="Tuliskan keluhan utama Anda..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Riwayat Pendaftaran Anda</h3></div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th><th>Poli</th><th>Dokter</th><th>Jadwal</th><th>Status</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat_daftar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $item->jadwal->poli->nama_poli ?? 'N/A' }}</td>
                                    <td>{{ $item->dokter->name ?? 'N/A' }}</td>
                                    <td>{{ $item->jadwal->hari ?? '' }}, {{ \Carbon\Carbon::parse($item->jadwal->jam_mulai ?? '')->format('H:i') }}</td>
                                    <td>
                                        @if($item->status == 'menunggu')<span class="badge bg-warning">Menunggu</span>
                                        @elseif($item->status == 'diterima')<span class="badge bg-success">Diterima</span>
                                        @elseif($item->status == 'selesai')<span class="badge bg-primary">Selesai</span>
                                        @else<span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td><a href="#" class="btn btn-xs btn-info">Detail</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">Anda belum pernah mendaftar poli.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    {{-- Kode JavaScript yang sudah disempurnakan --}}
    <script>
        $(document).ready(function() {
            $('#id_poli').on('change', function() {
                var poliID = $(this).val();
                var jadwalDropdown = $('#id_jadwal');

                // Kosongkan dan nonaktifkan dropdown saat memuat
                jadwalDropdown.empty().append('<option value="">Memuat...</option>').prop('disabled', true);

                if(poliID) {
                    // Lakukan permintaan AJAX ke server
                    $.ajax({
                        url: "{{ url('/get-jadwal-by-poli') }}/" + poliID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            // Aktifkan kembali dan kosongkan dropdown
                            jadwalDropdown.prop('disabled', false).empty();
                            
                            // Jika data ditemukan dan tidak kosong
                            if(data && data.length > 0) {
                                jadwalDropdown.append('<option value="">-- Pilih Jadwal --</option>');
                                $.each(data, function(key, value) {
                                    var jadwalText = value.hari + ', ' + value.jam_mulai.substring(0,5) + ' - ' + value.jam_selesai.substring(0,5) + ' (dr. ' + value.dokter.name + ')';
                                    jadwalDropdown.append('<option value="' + value.id + '">' + jadwalText + '</option>');
                                });
                            } else {
                                // Jika tidak ada jadwal yang ditemukan
                                jadwalDropdown.append('<option value="">-- Tidak ada jadwal aktif untuk poli ini --</option>');
                            }
                        },
                        error: function() {
                            // Jika terjadi error saat memuat data
                            jadwalDropdown.prop('disabled', false).empty().append('<option value="">-- Gagal memuat jadwal --</option>');
                        }
                    });
                } else {
                    // Jika tidak ada poli yang dipilih
                    jadwalDropdown.prop('disabled', false).empty().append('<option value="">-- Pilih Poli terlebih dahulu --</option>');
                }
            });
        });
    </script>
@endpush
