<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id');
            $table->foreignId('user_id');
            $table->integer('masuk')->default(0);
            $table->timestamp('waktu_masuk')->nullable();
            $table->integer('keluar')->default(0);
            $table->timestamp('waktu_keluar')->nullable();
            $table->enum('status_hadir', ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Izin', 'Alpa'])->default('Alpa');
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
        Schema::dropIfExists('absensi_staff');
    }
}
