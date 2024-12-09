<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    use HasFactory;

    protected $table='address';
    protected $fillable=[
        'user_id',
        'name',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'detail_address',
        'is_default'
    ];

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
