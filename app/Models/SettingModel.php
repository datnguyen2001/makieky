<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;

    protected $table = 'setting';
    protected $fillable = [
        'logo',
        'phone',
        'email',
        'address',
        'map',
        'facebook',
        'instagram',
        'youtube',
        'line',
    ];
}
