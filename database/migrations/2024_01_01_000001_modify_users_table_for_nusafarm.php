<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'landlord', 'petani', 'manager', 'logistik', 'pupuk_vendor'])->default('user');
            $table->integer('xp')->default(0);
            $table->integer('level')->default(1);
            $table->decimal('wallet_balance', 15, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'xp', 'level', 'wallet_balance']);
        });
    }
}; 