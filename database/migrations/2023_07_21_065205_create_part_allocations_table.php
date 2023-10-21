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
        Schema::create('part_allocations', function (Blueprint $table) {
            $table->id('part_allocation_id');
            $table->unsignedBigInteger('budget_id');
            $table->foreign('budget_id')->references('budget_id')->on('budgets')->onDelete('cascade');
            $table->string('part_name', 50);
            $table->decimal('allocation_amount', 10, 2);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_allocations');
    }
};
