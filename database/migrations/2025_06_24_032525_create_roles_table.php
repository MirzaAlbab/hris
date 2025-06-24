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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique(); // Unique name for the role
            $table->text('description')->nullable(); // Optional description of the role
            $table->string('permissions')->nullable(); // JSON or text field for storing permissions
            $table->timestamps();
            $table->softDeletes(); // For soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
