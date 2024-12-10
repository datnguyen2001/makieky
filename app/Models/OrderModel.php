<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];

    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class, 'order_id');
    }

    public function province()
    {
        return $this->belongsTo(ProvinceModel::class, 'province_id','province_id');
    }

    public function district()
    {
        return $this->belongsTo(DistrictModel::class, 'district_id','district_id');
    }

    public function ward()
    {
        return $this->belongsTo(WardModel::class, 'ward_id','wards_id');
    }
}
