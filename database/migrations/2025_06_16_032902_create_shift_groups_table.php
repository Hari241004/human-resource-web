<?php
// database/migrations/2025_06_16_000002_create_shift_groups_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shift_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Group 1, Group 2, …
            
            // Tambahkan ini:
            $table->foreignId('shift_id')
                  ->nullable()
                  ->constrained('shifts')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shift_groups');
    }
};
