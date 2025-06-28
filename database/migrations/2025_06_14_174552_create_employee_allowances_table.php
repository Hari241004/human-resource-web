<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_allowances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('tunjangan_id');
            $table->decimal('amount', 15, 2);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('tunjangan_id')->references('id')->on('tunjangan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_allowances');
    }
};
