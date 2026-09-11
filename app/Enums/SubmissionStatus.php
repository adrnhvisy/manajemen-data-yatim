<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED_TO_KECAMATAN = 'diajukan_ke_kecamatan';
    case RETURNED_TO_KELURAHAN = 'dikembalikan_ke_kelurahan';
    case SUBMITTED_TO_KESRA = 'diajukan_ke_kesra';
    case APPROVED = 'disetujui';
    case REJECTED = 'ditolak_kesra';
}
