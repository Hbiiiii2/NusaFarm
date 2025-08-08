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
        Schema::table('investments', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['project_id']);
            
            // Drop the project_id column
            $table->dropColumn('project_id');
            
            // Add the new farmland_id column
            $table->foreignId('farmland_id')->constrained('farmlands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['farmland_id']);
            
            // Drop the farmland_id column
            $table->dropColumn('farmland_id');
            
            // Add back the project_id column
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
        });
    }
};
