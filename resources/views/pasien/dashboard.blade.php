@extends('layouts.app')
@section('title', 'Dashboard Pasien')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-primary fw-bold">Dashboard Pasien</h1>
    </div>
@stop

@section('content')
<div class="container-fluid">

    {{-- Sambutan dan Jam Analog --}}
    <div class="row g-3 align-items-center mb-4">
        <div class="col-md-8">
            <div class="alert alert-info shadow-sm rounded-3 d-flex align-items-center h-100">
                <i class="fas fa-handshake fa-2x me-3 text-primary"></i>
                <div>
                    <h5 class="mb-0">Selamat datang, <strong>Tuan. {{ Auth::user()->name }}</strong>!</h5>
                    <small>Selamat datang di website kami. Semoga Anda sehat selalu.</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div id="clock" class="bg-white rounded-circle border border-2 shadow-sm mx-auto" style="width: 130px; height: 130px; position: relative;">
                <canvas id="analogClock" width="130" height="130"></canvas>
            </div>
        </div>
    </div>

    {{-- Kotak Statistik --}}
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="small-box bg-gradient-primary text-white rounded-3 shadow-sm">
                <div class="inner">
                    <h3>150</h3>
                    <p>Pasien Baru</p>
                </div>
                <div class="icon"><i class="ion ion-bag"></i></div>
                <a href="#" class="small-box-footer text-white">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="small-box bg-gradient-success text-white rounded-3 shadow-sm">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Tingkat Kunjungan</p>
                </div>
                <div class="icon"><i class="ion ion-stats-bars"></i></div>
                <a href="#" class="small-box-footer text-white">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="small-box bg-gradient-info text-white rounded-3 shadow-sm">
                <div class="inner">
                    <h3>44</h3>
                    <p>Jadwal Terdaftar</p>
                </div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                <a href="#" class="small-box-footer text-white">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="small-box bg-gradient-danger text-white rounded-3 shadow-sm">
                <div class="inner">
                    <h3>65</h3>
                    <p>Pemeriksaan Selesai</p>
                </div>
                <div class="icon"><i class="ion ion-pie-graph"></i></div>
                <a href="#" class="small-box-footer text-white">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Saran dan Masukan --}}
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-comments me-2"></i> Saran dan Masukan
        </div>
        <div class="card-body">
            <p class="mb-3">Kami selalu berusaha memberikan layanan terbaik. Jika Anda memiliki saran, kritik, atau masukan, silakan sampaikan kepada kami:</p>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" rows="4" name="feedback" placeholder="Tulis masukan Anda di sini..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Masukan</button>
            </form>
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
    ctx.setTransform(1, 0, 0, 1, 0, 0); // Reset transform
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
    // Konversi waktu ke WIB (UTC+7)
    const now = new Date(nowUTC.getTime() + (7 * 60 * 60 * 1000));

    let hour = now.getUTCHours();
    let minute = now.getUTCMinutes();
    let second = now.getUTCSeconds();

    // Hitung posisi jarum jam
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


<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush
