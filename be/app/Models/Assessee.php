<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessee extends Model
{
    /** @use HasFactory<\Database\Factories\AssesseeFactory> */
    use HasFactory;

    /**
     * The path to the directory where the files are stored.
     *
     * @var string
     */
    const FILE_PATH = 'img/assessees';

    /**
     * The status of the assessee.
     *
     * @var array
     */
    const STATUS = [
        'requested' => 'Requested',
        'approved' => 'Approved',
        'completed' => 'Completed',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assessees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'instance_id',
        'name',
        'email',
        'phone_number',
        'address',
        'identity_number',
        'birth_date',
        'birth_place',
        'last_education_level',
        'schema_id',
        'method',
        'assessment_date',
        'last_education_certificate_path',
        'identity_card_path',
        'family_card_path',
        'self_photo_path',
        'apl01_path',
        'apl02_path',
        'supporting_documents_path',
        'assessment_result',
        'assessment_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'assessment_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the assessee.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the instance that owns the assessee.
     */
    public function instance() : BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    /**
     * Get the schema that is used for this assessee.
     */
    public function schema() : BelongsTo
    {
        return $this->belongsTo(Schema::class);
    }

    /**
     * Get supporting documents as an array.
     *
     * @return array
     */
    public function getSupportingDocumentsAttribute() : array
    {
        if (empty($this->supporting_documents_path)) {
            return [];
        }

        return json_decode($this->supporting_documents_path, true) ?? [];
    }

    /**
     * Set supporting documents from an array.
     *
     * @param array $documents
     * @return void
     */
    public function setSupportingDocumentsAttribute(array $documents) : void
    {
        $this->attributes['supporting_documents_path'] = json_encode($documents);
    }

    /**
     * Check if the assessee has completed all required documents.
     *
     * @return bool
     */
    public function hasCompletedDocuments() : bool
    {
        $dokumenLengkap =
            !empty($this->last_education_certificate_path) &&
            !empty($this->identity_card_path) &&
            !empty($this->family_card_path) &&
            !empty($this->self_photo_path);

        $hasAplUploads = $this->berkasApl()->exists();

        return $dokumenLengkap && $hasAplUploads;
    }


    /**
     * Get the status of the assessee's assessment process.
     *
     * @return string
     */
    public function getStatusText() : string
    {
        $status = $this->assessment_status;

        return match ($status) {
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => 'Menunggu'
        };
    }

    /**
     * Get the certificate that is assigned to the assessee.
     */
    public function certificate() : HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function berkasApl()
    {
        return $this->hasMany(BerkasApl::class, 'assessee_id');
    }
}
