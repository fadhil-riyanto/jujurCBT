<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperadminModel extends Model
{
    use HasFactory;
    protected $table = "superadmin_credential";
    protected $fillable = ["username", "password"];
    protected $primaryKey = "id";
}
