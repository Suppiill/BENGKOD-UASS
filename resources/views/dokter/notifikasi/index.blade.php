@extends('adminlte::page')

@section('title', 'Notifikasi')

@section('content_header')
    <h1>Notifikasi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Semua Notifikasi</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                @forelse ($notifikasis as $notif)
                    <a href="{{ $notif->link ?? '#' }}" class="list-group-item list-group-item-action flex-column align-items-start {{ $notif->is_read ? '' : 'bg-light' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                <i class="fas fa-bell text-primary"></i> 
                                {{-- Jika belum dibaca, tampilkan sebagai tebal --}}
                                {!! $notif->is_read ? $notif->pesan : '<strong>' . $notif->pesan . '</strong>' !!}
                            </h5>
                            <small>{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada notifikasi untuk Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@stop