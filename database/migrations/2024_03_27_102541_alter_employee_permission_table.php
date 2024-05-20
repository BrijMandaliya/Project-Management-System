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
        Schema::table('employee_permission', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->string('on_create_ip')->after('permission_id');
            $table->string('on_update_ip')->after('on_create_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
