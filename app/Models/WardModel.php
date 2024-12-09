<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardModel extends Model
{
    use HasFactory;
    protected $table = 'wards';
    protected $fillable = [
        'wards_id',
        'district_id',
        'name'
    ];

    public function addresses()
    {
        return $this->hasMany(AddressModel::class, 'ward_id');
    }
}
