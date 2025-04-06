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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('payment_method', 50)->nullable();
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('net_tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->date('sale_date');
            $table->string('status', 50);
            // Foreign Keys
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('seller_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('sale_date');
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
