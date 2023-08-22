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
        Schema::create('expense_sharing_groups', function (Blueprint $table) {
            $table->bigIncrements('group_id');
            $table->string('group_name', 50);
            $table->string('group_description', 50);
            $table->date('creation_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_sharing_groups');
    }
};
