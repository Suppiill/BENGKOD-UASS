@extends('adminlte::page')

@section('title', 'Edit Jadwal Operasi')

@section('content_header')
    <h1>Edit Jadwal Operasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('dokter.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Method untuk update --}}

            <div class="form-group">
                <label for="pasien_id">Pilih Pasien</label>
                <select name="pasien_id" id="pasien_id" class="form-control">
                    @foreach ($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ $jadwal->pasien_id == $pasien->id ? 'selected' : '' }}>
                            {{ $pasien->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Isi field lain dengan data dari $jadwal --}}

            <button type="submit" class="btn btn-primary">Update Jadwal</button>
        </form>
    </div>
</div>
@stop