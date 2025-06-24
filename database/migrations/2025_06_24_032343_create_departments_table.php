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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Unique name for the department
            $table->text('description')->nullable(); // Optional description of the department
            $table->string('head')->nullable(); // Name of the department head or manager
            $table->string('status')->default('active'); // e.g., active, inactive
            $table->timestamps();
            $table->softDeletes(); // For soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
