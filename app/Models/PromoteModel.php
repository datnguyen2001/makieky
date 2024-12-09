<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoteModel extends Model
{
    use HasFactory;
    protected $table='promotes';
    protected $fillable=[
        'name',
        'link',
        'src',
        'display'
    ];
}
