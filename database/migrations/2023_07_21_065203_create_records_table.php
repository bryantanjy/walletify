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
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('record_id'); // Big integer auto-incrementing primary key 'record_id'
            $table->unsignedBigInteger('user_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('account_id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            // $table->unsignedBigInteger('group_id');
            // $table->foreign('group_id')->references('group_id')->on('expense_sharing_groups')->onDelete('cascade');
            $table->string('record_type', 50);
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('time');
            $table->string('record_description', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
