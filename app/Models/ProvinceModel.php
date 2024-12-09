<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $fillable = [
        'province_id',
        'name'
    ];

    public function addresses()
    {
        return $this->hasMany(AddressModel::class, 'province_id');
    }
}
