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
        Schema::create('attendance_logs', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('user_id')->index();
        $table->uuid('gym_branch_id')->index();
        $table->enum('type', ['member', 'staff'])->index();
        $table->timestamp('checked_in_at')->nullable();
        $table->timestamp('checked_out_at')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        $table->foreign('gym_branch_id')->references('id')->on('gym_branches')->cascadeOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
