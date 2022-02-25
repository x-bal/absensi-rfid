<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id');
            $table->foreignId('siswa_id');
            $table->integer('masuk')->default(0);
            $table->timestamp('waktu_masuk')->nullable();
            $table->integer('keluar')->default(0);
            $table->timestamp('waktu_keluar')->nullable();
            $table->string('status_hadir')->default('Alpa');
            $table->foreignId('edited_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensis');
    }
}
