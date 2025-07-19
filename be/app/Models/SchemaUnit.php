<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchemaUnit extends Model
{
    /** @use HasFactory<\Database\Factories\SchemaUnitFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schema_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schema_id',
        'code',
        'name',
    ];

    /**
     * Get the schema that the unit belongs to.
     */
    public function schema(): BelongsTo
    {
        return $this->belongsTo(Schema::class);
    }
}
