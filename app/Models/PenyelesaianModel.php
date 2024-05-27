<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyelesaianModel extends Model
{
    use HasFactory;
    
    protected $table = "penyelesaian";
    protected $fillable = ["kode_mapel", "nomor_ujian", "penugasan_id", "is_end"];
    protected $primaryKey = "id";

}
