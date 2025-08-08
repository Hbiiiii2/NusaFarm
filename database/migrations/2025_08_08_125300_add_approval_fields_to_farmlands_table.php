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
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('rejected_at')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_by_admin_at')->nullable();
            $table->foreignId('approved_by_admin_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('ready_for_investment_at')->nullable();
            $table->foreignId('ready_for_investment_by')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('investment_period_months', 5, 2)->nullable();
            $table->decimal('required_investment_amount', 15, 2)->nullable();
            $table->decimal('minimum_investment_amount', 15, 2)->nullable();
            $table->text('investment_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmlands', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropForeign(['approved_by_admin_by']);
            $table->dropForeign(['ready_for_investment_by']);
            $table->dropColumn([
                'verified_at', 'verified_by', 'rejected_at', 'rejected_by', 'rejection_reason',
                'approved_by_admin_at', 'approved_by_admin_by', 'ready_for_investment_at', 
                'ready_for_investment_by', 'investment_period_months', 'required_investment_amount',
                'minimum_investment_amount', 'investment_notes'
            ]);
        });
    }
};
