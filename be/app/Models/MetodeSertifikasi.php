<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodeSertifikasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    const IMAGE_URL_PATH = 'file/metode_sertifikasi';
}
