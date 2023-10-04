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
        Schema::create('budget_templates', function (Blueprint $table) {
            $table->bigIncrements('template_id');
            $table->unsignedBigInteger('budget_id');
            $table->foreign('budget_id')->references('budget_id')->on('budgets')->onDelete('cascade');
            $table->string('template_name', 50);
            $table->boolean('is_default');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_templates');
    }
};
