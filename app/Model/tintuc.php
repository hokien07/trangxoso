<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class tintuc extends Model
{

    // Thay đổi các thiết lập ngầm định của Eloquent Model

    protected $table = 'tin_tuc';
    public $primaryKey = 'id_tin';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_tin', 'tin_tieu_de', 'tin_rut_gon', 'tin_noi_dung', 'tin_hinh_anh', 'link_bai_viet', 'link_hinh_anh'];

}
