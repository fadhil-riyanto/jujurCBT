<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaAccountModel extends Model
{
    use HasFactory;
    protected $table = "siswa_account";
    protected $primaryKey = "id";
    protected $fillable = ['nama', 'kelas', 'nomor_ujian', 'password', 'blokir'];

}

