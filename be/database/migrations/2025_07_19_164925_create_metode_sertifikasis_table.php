<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('metode_sertifikasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_metode')->nullable();
            $table->text('file')->nullable();
            $table->text('file_path')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('metode_sertifikasis');
    }
};
