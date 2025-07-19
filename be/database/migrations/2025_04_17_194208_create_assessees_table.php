<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('instance_id')->constrained('instances');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('identity_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('last_education_level')->nullable();

            // schema and method
            $table->foreignId('schema_id')->constrained('schemas')->nullable();
            $table->string('method')->nullable();
            $table->date('assessment_date')->nullable();

            // required documents
            $table->longText('last_education_certificate_path')->nullable();
            $table->longText('identity_card_path')->nullable();
            $table->longText('family_card_path')->nullable();
            $table->longText('self_photo_path')->nullable();
            $table->longText('apl01_path')->nullable();
            $table->longText('apl02_path')->nullable();
            $table->longText('supporting_documents_path')->nullable();

            // assessment result
            $table->string('assessment_result')->nullable();
            $table->string('assessment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessees');
    }
};
