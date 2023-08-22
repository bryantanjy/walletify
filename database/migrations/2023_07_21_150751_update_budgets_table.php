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
        Schema::table('budgets', function (Blueprint $table) {
            // Add a new column to the table
            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('template_id')->on('budget_templates')->onDelete('cascade');
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('group_id')->on('expense_sharing_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('template_id');
        Schema::dropColumns('group_id');
    }
};
