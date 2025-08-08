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
        Schema::table('farmlands', function (Blueprint $table) {
            $table->enum('status', [
                'available', 
                'rented', 
                'inactive', 
                'pending_verification', 
                'verified',
                'approved_by_admin',
                'ready_for_investment',
                'rejected'
            ])->default('available')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmlands', function (Blueprint $table) {
            $table->enum('status', ['available', 'rented', 'inactive', 'pending_verification', 'verified'])->default('available')->change();
        });
    }
};
