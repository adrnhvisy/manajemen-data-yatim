<?php

namespace App\Enums;

enum DocumentType: string
{
    case APPLICATION = 'surat_permohonan_pengajuan';
    case DISBURSEMENT = 'surat_permohonan_pencairan';
    case IDENTITY = 'ktp_orang_tua_wali';
    case FAMILY_CARD = 'kartu_keluarga';
    case BIRTH_CERTIFICATE = 'akte_kelahiran';
    case DEATH_CERTIFICATE = 'akte_kematian_orang_tua';
    case ORPHAN_STATEMENT = 'pernyataan_anak_yatim';
    case DOCUMENT_STATEMENT = 'pernyataan_kebenaran_dokumen';
    case RESPONSIBILITY_STATEMENT = 'pernyataan_tanggung_jawab';
    case BANK_ACCOUNT = 'rekening_bank';
    case PHOTO = 'pas_foto';
}
