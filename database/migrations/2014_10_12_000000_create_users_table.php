<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->default(0);
            $table->string('username')->unique();
            $table->string('nik');
            $table->string('nama');
            $table->string('password');
            $table->string('rfid')->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('gender', ['Laki - Laki', 'Perempuan']);
            $table->string('foto')->nullable();
            $table->integer('status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
