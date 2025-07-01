@extends('adminlte::page')

@section('title', 'Beranda Dokter')

@section('content_header')
    <h1 class="fw-bold text-primary"><i class="fas fa-home me-2"></i> Beranda Dokter</h1>
@stop

@section('content')
<div class="container-fluid">
    
    {{-- SAMBUTAN + JAM ANALOG --}}
    <div class="row g-4 mb-4 align-items-center">
        <div class="col-md-8">
            <div class="alert bg-gradient-info text-white shadow-sm p-4 rounded-4 d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="mb-1">Hai, Dr. {{ Auth::user()->name }}</h4>
                    <p class="mb-0">Selamat bertugas. Semoga hari Anda menyenangkan!</p>
                </div>
                <div>
                    <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" width="70" alt="Dokter">
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="bg-white rounded-circle border border-2 shadow-sm mx-auto d-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <canvas id="analogClock" width="110" height="110"></canvas>
            </div>
        </div>
    </div>

    {{-- OPSIONAL: RANGKUMAN DATA --}}
    {{-- INFORMASI PENTING --}}
<div class="row g-4 mt-4">

    {{-- RIWAYAT PASIEN --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-lg rounded-4 h-100 bg-gradient-info text-white position-relative overflow-hidden">
            <div class="card-body d-flex flex-column justify-content-center text-center">
                <div class="mb-3">
                    <i class="fas fa-history fa-3x"></i>
                </div>
                <h4 class="fw-bold">Riwayat Pasien</h4>
                <p>Lihat dan telusuri seluruh riwayat pemeriksaan pasien Anda.</p>
                <a href="{{ route('dokter.riwayat.index') }}" class="btn btn-outline-light mt-2 rounded-pill px-4">
                    Lihat Riwayat
                </a>
            </div>
        </div>
    </div>

    {{-- PROFIL DOKTER --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-lg rounded-4 h-100 bg-gradient-primary text-white position-relative overflow-hidden">
            <div class="card-body d-flex flex-column justify-content-center text-center">
                <div class="mb-3">
                    <i class="fas fa-user-md fa-3x"></i>
                </div>
                <h4 class="fw-bold">Profil Dokter</h4>
                <p>Kelola data pribadi, spesialisasi, dan preferensi akun Anda.</p>
                <a href="{{ route('dokter.profil') }}" class="btn btn-outline-light mt-2 rounded-pill px-4">
                    Lihat Profil
                </a>
            </div>
        </div>
    </div>

</div>



</div>
@stop

@push('js')
<script>
function drawClock() {
    const canvas = document.getElementById("analogClock");
    const ctx = canvas.getContext("2d");
    const radius = canvas.height / 2;
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.translate(radius, radius);

    setInterval(() => {
        ctx.clearRect(-radius, -radius, canvas.width, canvas.height);
        drawFace(ctx, radius);
        drawNumbers(ctx, radius);
        drawTime(ctx, radius);
    }, 1000);
}

function drawFace(ctx, radius) {
    ctx.beginPath();
    ctx.arc(0, 0, radius * 0.95, 0, 2 * Math.PI);
    ctx.fillStyle = "#ffffff";
    ctx.fill();
    ctx.lineWidth = 4;
    ctx.strokeStyle = "#0d6efd";
    ctx.stroke();
    ctx.beginPath();
    ctx.arc(0, 0, 5, 0, 2 * Math.PI);
    ctx.fillStyle = "#0d6efd";
    ctx.fill();
}

function drawNumbers(ctx, radius) {
    let ang;
    ctx.font = radius * 0.15 + "px Arial";
    ctx.textBaseline = "middle";
    ctx.textAlign = "center";
    for (let num = 1; num <= 12; num++) {
        ang = num * Math.PI / 6;
        ctx.rotate(ang);
        ctx.translate(0, -radius * 0.85);
        ctx.rotate(-ang);
        ctx.fillText(num.toString(), 0, 0);
        ctx.rotate(ang);
        ctx.translate(0, radius * 0.85);
        ctx.rotate(-ang);
    }
}

function drawTime(ctx, radius) {
    const nowUTC = new Date();
    const now = new Date(nowUTC.getTime() + (7 * 60 * 60 * 1000)); // WIB = UTC+7

    let hour = now.getUTCHours();
    let minute = now.getUTCMinutes();
    let second = now.getUTCSeconds();

    hour = hour % 12;
    hour = (hour * Math.PI / 6) +
           (minute * Math.PI / (6 * 60)) +
           (second * Math.PI / (360 * 60));
    drawHand(ctx, hour, radius * 0.5, 6);

    minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
    drawHand(ctx, minute, radius * 0.75, 4);

    second = (second * Math.PI / 30);
    drawHand(ctx, second, radius * 0.85, 2, "#dc3545");
}

function drawHand(ctx, pos, length, width, color = "#0d6efd") {
    ctx.beginPath();
    ctx.lineWidth = width;
    ctx.lineCap = "round";
    ctx.strokeStyle = color;
    ctx.moveTo(0, 0);
    ctx.rotate(pos);
    ctx.lineTo(0, -length);
    ctx.stroke();
    ctx.rotate(-pos);
}

document.addEventListener("DOMContentLoaded", drawClock);
</script>
@endpush
