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
        Schema::create('fertilizer_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // penyedia pupuk
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('fertilizer_name');
            $table->text('description');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'processing', 'ready', 'shipped', 'delivered'])->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizer_orders');
    }
};
