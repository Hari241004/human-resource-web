<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (! Schema::hasColumn('employees', 'bank_name')) {
                $table->string('bank_name')->default('Mandiri')->after('position_id');
            }
            if (! Schema::hasColumn('employees', 'bank_account_name')) {
                $table->string('bank_account_name')->nullable()->after('bank_name');
            }
            if (! Schema::hasColumn('employees', 'bank_account_number')) {
                $table->string('bank_account_number')->nullable()->after('bank_account_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'bank_account_number')) {
                $table->dropColumn('bank_account_number');
            }
            if (Schema::hasColumn('employees', 'bank_account_name')) {
                $table->dropColumn('bank_account_name');
            }
            if (Schema::hasColumn('employees', 'bank_name')) {
                $table->dropColumn('bank_name');
            }
        });
    }
};
