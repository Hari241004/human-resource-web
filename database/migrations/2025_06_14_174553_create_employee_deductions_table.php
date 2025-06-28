<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employee_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('potongan_id')->constrained('potongan')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('employee_deductions');
    }
};

