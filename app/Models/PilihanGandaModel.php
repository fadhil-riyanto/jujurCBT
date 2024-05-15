<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanGandaModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "mata_pelajaran", "nomor_soal", "pilihan_text", "index_jawaban"
        // kodemapel, idsoal, (A B C), jawaban 0 = A, 1 = B, 2 = C
    ];
    protected $table = "pilihan_ganda";
    protected $primaryKey = "id";
}
