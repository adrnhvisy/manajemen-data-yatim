<?php

namespace App\Enums;

enum Role: string
{
    case KELURAHAN = 'kelurahan';
    case KECAMATAN = 'kecamatan';
    case KESRA = 'kesra';
    case ADMIN = 'admin';
}
