<?php

namespace App\Enums;

enum StatusJanjiTemu: string
{
    case MENUNGGU = 'menunggu';
    case DITERIMA = 'diterima';
    case DITOLAK = 'ditolak';
    case SELESAI = 'selesai';
}