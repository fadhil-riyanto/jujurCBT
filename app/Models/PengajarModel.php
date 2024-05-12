<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajarModel extends Model
{
    use HasFactory;
    protected $table = 'pengajar';
    protected $fillable = ['nama', 'username', 'password'. 'mata_pelajaran'];
}
