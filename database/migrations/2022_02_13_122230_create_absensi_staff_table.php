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
            $table->string('waktu');
            $table->integer('masuk')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpa')->default(1);
            $table->integer('keluar')->default(0);
            $table->string('keterangan');
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
