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
        Schema::create('market_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pedagang pasar
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->text('description');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'harvesting', 'ready', 'delivered', 'received'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('harvesting_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->text('feedback')->nullable();
            $table->integer('rating')->nullable(); // 1-5 stars
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_orders');
    }
};
