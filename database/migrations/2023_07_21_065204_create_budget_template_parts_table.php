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
        Schema::create('budget_template_parts', function (Blueprint $table) {
            $table->bigIncrements('part_id');
            // $table->unsignedBigInteger('template_id');
            // $table->foreign('template_id')->references('template_id')->on('budget_templates')->onDelete('cascade');
            $table->string('part_name', 50);
            $table->string('amount', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_template_parts');
    }
};
