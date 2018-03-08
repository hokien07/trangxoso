<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ten_tinh extends Model
{
    protected $table = 'ten_tinh';
    protected $fillable = [
       'id_tinh', 'ten_tinh', 'mo_thuong', 'tinh_vung'
    ];

}
