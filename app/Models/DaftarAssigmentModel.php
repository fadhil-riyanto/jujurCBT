<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarAssigmentModel extends Model
{
    use HasFactory;
    protected $table = "daftar_assignment";
    protected $primaryKey = "id";
    protected $fillable = ["nomor_ujian", "jenis_mapel", "status_dikerjakan", "status_selesai"];
}
