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
            $table->foreignId('roles_id')->constrained();
            $table->string('emp_name');
            $table->string('emp_email')->unique();
            $table->string('emp_phone_number')->unique();
            $table->string('emp_code')->unique();
            $table->string('emp_address');
            $table->string('emp_country');
            $table->string('emp_profile_image');
            $table->string('emp_password');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_employees');
    }
};
