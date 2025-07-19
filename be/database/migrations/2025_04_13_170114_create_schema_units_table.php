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
        Schema::create('schema_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schema_id')->constrained('schemas');
            $table->string('code');
            $table->string('name');
            $table->timestamps();

            $table->unique(['schema_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schema_units');
    }
};
