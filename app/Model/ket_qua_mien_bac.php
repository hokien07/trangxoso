<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ket_qua_mien_bac extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // Thay đổi các thiết lập ngầm định của Eloquent Model
    protected $table = 'ket_qua_mien_bac';
    public $primaryKey = 'id_ket_qua_mien_bac';
    public $incrementing = true;
    public $timestamps = false;

    public $mien_bac_dac_biet;
    public $mien_bac_giai_nhat;
    public $mien_bac_giai_nhi;
    public $mien_bac_giai_ba;
    public $mien_bac_giai_bon;
    public $mien_bac_giai_nam;
    public $mien_bac_giai_sau;
    public $mien_bac_giai_bay;
    public $tinh_vung;
    public $ngay_mo_thuong;

    protected $fillable = ['mien_bac_dac_biet', 'mien_bac_giai_nhat', 'mien_bac_giai_nhi', 'mien_bac_giai_ba', 'mien_bac_giai_bon', 'mien_bac_giai_nam', 'mien_bac_giai_sau', 'mien_bac_giai_bay', 'tinh_vung', 'ngay_mo_thuong'];


}
