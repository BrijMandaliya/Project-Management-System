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
        Schema::create('task_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('task_id');
            $table->string('task_title');
            $table->foreignId('project_id')->constrained();
            $table->string('task_type');
            $table->foreignId('task_posted_by')->constrained();
            $table->string('task_assign_to');
            $table->string('task_DeadLine');
            $table->string('task_Completed_On');
            $table->string('task_images')->nullable();
            $table->string('on_task_create_ip');
            $table->string('on_task_update_ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_task__details');
    }
};
