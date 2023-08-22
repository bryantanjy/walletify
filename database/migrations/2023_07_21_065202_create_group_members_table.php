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
        Schema::create('group_members', function (Blueprint $table) {
            $table->bigIncrements('member_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->unsignedBigInteger('group_id');
            // $table->foreign('group_id')->references('group_id')->on('expense_sharing_groups')->onDelete('cascade');
            $table->string('role', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
