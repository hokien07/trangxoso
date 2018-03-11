<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ten_tinh extends Model
{
    // Thay đổi các thiết lập ngầm định của Eloquent Model

    protected $table = 'ten_tinh';
    public $primaryKey = 'id_tinh';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_tinh', 'ten_tinh', 'mo_thuong', 'tinh_vung', 'ten_tinh_khong_dau', 'ma_tinh'];

}
