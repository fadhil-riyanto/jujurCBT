<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanModel extends Model
{
    use HasFactory;
    protected $table = "penugasan";
    protected $fillable = ["kelas_id", "kode_mapel", "start_date", "start_time",
             "duration_time", "unix" ];

    protected $primaryKey = 'id';
}
