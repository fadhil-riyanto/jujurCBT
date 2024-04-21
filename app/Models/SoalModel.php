<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalModel extends Model
{
    use HasFactory;
    protected $table = "soal";
    protected $primaryKey = "id";
    protected $fillable = ["mata_pelajaran", "nomor_soal", "image_soal", "text_soal",
                            "index_kunci_jawaban"];
}

class EssayModel extends Model
{
    use HasFactory;
    protected $table = "essay";
    protected $primaryKey = "id";
    protected $fillable = ["mata_pelajaran", "nomor_soal", "image_soal", "text_soal"];

    // karna soal essay tidak memerlukan kunci jawaban
}

class PilihanGandaModel extends Model
{
    use HasFactory;
    protected $table = "pilihan_ganda";
    protected $primaryKey = "id";
    protected $fillable = ["mata_pelajaran", "nomor_soal", "pilihan_text", "index_jawaban"];

    // wadah jawaban A B C D untuk cbt
}