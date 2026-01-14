<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    //
    public $table = 'couriers';
    protected $tables = ['nama_depan', 'nama_belakang', 'no_telp', 'email', 'alamat_domisili', 'status', 'level'];
}
