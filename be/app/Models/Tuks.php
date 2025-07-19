<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuks extends Model
{
    /** @use HasFactory<\Database\Factories\TuksFactory> */
    use HasFactory;

    const IMAGE_URL_PATH = 'img/tuks';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tuks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image_url',
        'address',
        'phone',
        'type',
    ];
}
