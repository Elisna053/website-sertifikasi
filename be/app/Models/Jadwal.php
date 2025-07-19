<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function instance()
    {
        return $this->belongsTo(Instance::class, 'instance_id');
    }
}
