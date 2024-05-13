<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarMataPelajaranModel extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "daftar_mata_pelajaran";
    protected $fillable = ["kode_mata_pelajaran", "nama_mata_pelajaran", "pengampu"];

}
