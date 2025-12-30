<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProperty extends Model
{
    use HasFactory;

    protected $table = 'data_property';

    protected $fillable = [
        'satuan',
        'nama',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
