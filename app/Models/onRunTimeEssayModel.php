<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class onRunTimeEssayModel extends Model
{
    use HasFactory;
    protected $table = "on_runtime_essay";
    protected $fillable = [
        "nomor_ujian", "mata_pelajaran", "jawaban_txt", "id_soal", "is_fixed", "is_correct"
    ];

    protected $primaryKey = "id";
}
