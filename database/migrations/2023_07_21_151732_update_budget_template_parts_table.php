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
        Schema::table('budget_template_parts', function (Blueprint $table) {
            // Add a new column to the table
            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('template_id')->on('budget_templates')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('template_id');
    }
};
