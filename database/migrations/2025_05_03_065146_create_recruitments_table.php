<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->text('address');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('kk_number');
            $table->string('religion');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->date('contract_end_date');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->enum('marital_status', ['Sudah Kawin', 'Belum Kawin']);
            $table->string('education');
            $table->date('tmt');
            $table->decimal('salary', 15, 2);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};