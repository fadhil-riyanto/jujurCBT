<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssayModel extends Model
{
    use HasFactory;

    protected $fillable = [
        "mata_pelajaran", "nomor_soal", "image_soal", "text_soal"
    ];
    
    protected $table = "essay ";
    protected $primaryKey = "id";
}
