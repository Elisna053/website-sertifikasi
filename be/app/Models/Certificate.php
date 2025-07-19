<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\CertificateFactory> */
    use HasFactory;

    /**
     * The path to the directory where the files are stored.
     *
     * @var string
     */
    const FILE_PATH = 'img/certificates';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'certificates';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assessee_id',
        'certificate_number',
        'certificate_path',
    ];

    /**
     * Get the assessee that owns the certificate.
     */
    public function assessee() : BelongsTo
    {
        return $this->belongsTo(Assessee::class);
    }
}
