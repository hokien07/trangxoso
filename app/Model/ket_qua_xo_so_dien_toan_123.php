<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ket_qua_xo_so_dien_toan_123 extends Model
{
    // Thay đổi các thiết lập ngầm định của Eloquent Model
    protected $table = 'ket_qua_xo_so_dien_toan_123';
    public $primaryKey = 'id_dien_toan_123';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['ngay_xo_dien_toan_123', 'giai_dien_toan_123', 'id_tinh'];

}
