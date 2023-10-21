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
        Schema::create('part_allocation_categories', function (Blueprint $table) {
            $table->id('pac_id');
            $table->unsignedBigInteger('part_allocation_id');
            $table->foreign('part_allocation_id')->references('part_allocation_id')->on('part_allocations')->onDelete('cascade');
            $table->string('category_id', 3);
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_allocation_categories');
    }
};
