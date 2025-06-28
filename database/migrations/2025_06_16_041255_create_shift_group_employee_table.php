<?php
// database/migrations/2025_06_17_000000_create_shift_group_employee_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shift_group_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_group_id')
                  ->constrained('shift_groups')
                  ->cascadeOnDelete();
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['shift_group_id', 'employee_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shift_group_employee');
    }
};
