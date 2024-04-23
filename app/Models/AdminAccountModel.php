<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccountModel extends Model
{
    use HasFactory;

    protected $table = "admin_account";
    protected $primaryKey = "id";
    protected $fillable = ['username', 'password', 'nama'];

}
