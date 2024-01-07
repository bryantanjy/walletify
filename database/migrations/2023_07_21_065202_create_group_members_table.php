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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('expense_sharing_group_id');
            $table->foreign('expense_sharing_group_id')->references('id')->on('expense_sharing_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->default('Group Collaborator');
            $table->json('permissions')->nullable();
            $table->timestamps();

            // Add a unique constraint if you want to ensure uniqueness of user-group-role combinations
            $table->unique(['user_id', 'expense_sharing_group_id', 'role_id']);
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
