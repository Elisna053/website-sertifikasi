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
        Schema::create('berkas_apls', function (Blueprint $table) {
            $table->id();

            $table->integer('assessee_id')->nullable();
            $table->integer('schema_id')->nullable();
            $table->integer('schema_unit_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('file')->nullable();
            $table->string('file_path')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('berkas_apls');
    }
};
