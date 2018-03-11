<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ket_qua_mien_nam extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // Thay đổi các thiết lập ngầm định của Eloquent Model
    protected $table = 'ket_qua_mien_nam';
    public $primaryKey = 'id_ket_qua_xo_so';
    public $incrementing = true;
    public $timestamps = false;


    protected $fillable = ['dac_biet', 'giai_nhat', 'giai_nhi', 'giai_ba', 'giai_bon', 'giai_nam', 'giai_sau', 'giai_bay', 'giai_tam', 'tinh_vung', 'ngay_mo_thuong', 'id_tinh'];

}
