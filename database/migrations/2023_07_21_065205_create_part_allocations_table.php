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
            $table->bigIncrements('allocation_id');
            $table->unsignedBigInteger('part_id');
            $table->foreign('part_id')->references('part_id')->on('budget_template_parts')->onDelete('cascade');
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
