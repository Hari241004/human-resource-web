<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('description');
            $table->enum('type', ['Masuk','Warning','Libur'])->default('Masuk');
            // Tambahkan kolom color: untuk override warna event
            $table->string('color', 7)->default('#1cc88a'); // hijau default untuk "Masuk"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendars');
    }
};
