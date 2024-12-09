<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroduceModel extends Model
{
    use HasFactory;
    protected $table='introduce';
    protected $fillable=[
        'name',
        'slug',
        'describe',
        'content',
        'src',
        'display'
    ];
}
