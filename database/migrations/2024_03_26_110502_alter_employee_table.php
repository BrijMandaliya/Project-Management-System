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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('emp_gender');
            $table->date('emp_DOB');
            $table->string('on_update_id')->after('emp_DOB')->nullable();
            $table->string('on_create_ip')->after('on_update_id');
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
