<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, delete any users with problematic roles
        DB::table('users')->where('role', 'manager')->delete();
        
        // Then change the enum
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'landlord', 'petani', 'manajer_lapangan', 'logistik', 'penyedia_pupuk', 'pedagang_pasar', 'admin'])->default('user')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'landlord', 'manager'])->default('user')->change();
        });
    }
};
