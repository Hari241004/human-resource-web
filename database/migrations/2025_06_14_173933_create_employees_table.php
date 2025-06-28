<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Relasi ke users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Data dasar
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('email')->unique();
            $table->enum('gender', ['Laki-laki','Perempuan']);
            $table->string('title')->nullable();
            $table->string('photo')->nullable();

            // Kolom tambahan
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('tmt')->nullable();
            $table->date('contract_end_date')->nullable();

            // FK ke department & position
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained('departments')
                  ->onDelete('set null');
            $table->foreignId('position_id')
                  ->nullable()
                  ->constrained('positions')
                  ->onDelete('set null');

            // Informasi bank
            $table->string('bank_name')->default('Mandiri');
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();

            // Tambah kolom salary (tanpa after())
            $table->decimal('salary', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
