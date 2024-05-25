<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class onRunTimePilihanGandaModel extends Model
{
    use HasFactory;
    protected $table = "on_runtime_pilihan_ganda";
    protected $fillable = [
        "nomor_ujian", "mata_pelajaran", "index_jawaban", "is_fixed", "is_correct", "id_soal"
    ];

    protected $primaryKey = "id";
}
