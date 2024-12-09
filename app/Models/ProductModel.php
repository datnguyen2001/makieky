<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=[
        'name',
        'slug',
        'describe',
        'category_id',
        'trademark_id',
        'content',
        'ingredients',
        'src',
        'price',
        'quantity',
        'sold',
        'display'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function trademark()
    {
        return $this->belongsTo(TrademarkModel::class, 'trademark_id');
    }
}
