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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Foreign key to employees table
            $table->date('date'); // Date of the presence record
            $table->time('check_in_time')->nullable(); // Check-in time
            $table->time('check_out_time')->nullable(); // Check-out time
            $table->string('status')->default('present'); // Status of the presence
            $table->timestamps();
            $table->softDeletes(); // For soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
