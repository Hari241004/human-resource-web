<?php
// database/migrations/2025_06_16_000004_create_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_group_id')->constrained('shift_groups')->cascadeOnDelete();
            $table->date('date');
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['shift_group_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
