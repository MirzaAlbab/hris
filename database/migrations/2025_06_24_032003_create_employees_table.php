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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address');
            $table->date('birth_date');
            $table->date('hire_date');
            $table->decimal('salary', 10, 2);
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade'); // Assuming a departments table exists
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Assuming a roles table exists
            $table->string('status')->default('active'); // e.g., active, inactive
            $table->string('profile_picture')->nullable(); // URL or path to the profile picture
            $table->timestamps();
            $table->softDeletes(); // For soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
