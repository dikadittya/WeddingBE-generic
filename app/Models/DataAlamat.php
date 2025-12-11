<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAlamat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'data_alamat';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kode_alamat',
        'nama_provinsi',
        'kode_provinsi',
        'nama_kabupaten',
        'kode_kabupaten',
        'nama_kecamatan',
        'kode_kecamatan',
        'nama_desa',
        'kode_desa',
        'jarak',
        'kd_rumahan',
        'kd_gedung',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'jarak' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Get the member's created_at and updated_at date formatted.
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

}
