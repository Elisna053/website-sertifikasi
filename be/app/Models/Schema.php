<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schema extends Model
{
    /** @use HasFactory<\Database\Factories\SchemaFactory> */
    use HasFactory;

    const IMAGE_URL_PATH = 'img/schemas';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schemas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'image_url',
    ];

    /**
     * Get the units for the schema.
     */
    public function units() : HasMany
    {
        return $this->hasMany(SchemaUnit::class);
    }

    /**
     * Get the assessees for the schema.
     */
    public function assessees() : HasMany
    {
        return $this->hasMany(Assessee::class);
    }
}
