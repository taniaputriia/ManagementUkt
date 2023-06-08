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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('foreign key user');
            $table->text('nim')->comment('nim');
            $table->string('name')->comment('nama');
            $table->string('gender')->comment('jenis kelamin');
            $table->string('phone_number')->comment('nomor hp');
            $table->text('address')->comment('alamat');
            $table->string('study_program')->comment('program studi');
            $table->string('major')->comment('jurusan');
            $table->bigInteger('semester')->comment('semester');
            $table->bigInteger('academic_year')->comment('tahun akademik');
            $table->bigInteger('tuition_fee')->nullable()->comment('bayaran kuliah');
            $table->string('photo')->nullable()->comment('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
