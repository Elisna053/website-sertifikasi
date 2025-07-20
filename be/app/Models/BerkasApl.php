<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BerkasApl extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function units()
    {
        return $this->belongsTo(SchemaUnit::class, 'schema_unit_id');
    }
}
