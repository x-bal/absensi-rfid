<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id');
            $table->foreignId('device_id')->default(0);
            $table->char('nisn', 20);
            $table->string('nama');
            $table->enum('gender', ['Laki - Laki', 'Perempuan']);
            $table->string('rfid')->nullable();
            $table->string('status_pelajar')->default('Siswa');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('siswas');
    }
}
