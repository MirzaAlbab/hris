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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Title of the task
            $table->text('description')->nullable(); // Description of the task
            $table->foreignId('assigned_to')->constrained('employees')->onDelete('cascade');
            $table->date('due_date')->nullable(); // Due date for the task
            $table->string('status')->default('pending'); // Status of the task
            $table->timestamps();
            $table->softDeletes(); // For soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
