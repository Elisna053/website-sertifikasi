<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    /** @use HasFactory<\Database\Factories\PartnershipFactory> */
    use HasFactory;

    const IMAGE_URL_PATH = 'img/partnerships';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partnerships';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
    ];
}
