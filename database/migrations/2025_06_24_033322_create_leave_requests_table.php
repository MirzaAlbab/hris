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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Foreign key to employees table
            $table->date('start_date'); // Start date of the leave
            $table->date('end_date'); // End date of the leave
            $table->string('type')->default('vacation');
            $table->string('status')->default('pending'); // e.g., pending, approved, rejected
            $table->timestamps();
            $table->softDeletes(); // For soft deletion
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
