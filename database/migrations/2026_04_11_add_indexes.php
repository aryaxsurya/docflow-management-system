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
        // Add indexes untuk pengajuan table
        Schema::table('pengajuan', function (Blueprint $table) {
            if (!Schema::hasIndex('pengajuan', 'pengajuan_status_index')) {
                $table->index('status');
            }
            if (!Schema::hasIndex('pengajuan', 'pengajuan_user_id_index')) {
                $table->index('user_id');
            }
            if (!Schema::hasIndex('pengajuan', 'pengajuan_current_reviewer_level_index')) {
                $table->index('current_reviewer_level');
            }
        });

        // Add indexes untuk review_logs table
        Schema::table('review_logs', function (Blueprint $table) {
            if (!Schema::hasIndex('review_logs', 'review_logs_pengajuan_id_index')) {
                $table->index('pengajuan_id');
            }
            if (!Schema::hasIndex('review_logs', 'review_logs_reviewer_id_index')) {
                $table->index('reviewer_id');
            }
        });

        // Add indexes untuk users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasIndex('users', 'users_status_index')) {
                $table->index('status');
            }
            if (!Schema::hasIndex('users', 'users_role_index')) {
                $table->index('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropIndexIfExists('pengajuan_status_index');
            $table->dropIndexIfExists('pengajuan_user_id_index');
            $table->dropIndexIfExists('pengajuan_current_reviewer_level_index');
        });

        Schema::table('review_logs', function (Blueprint $table) {
            $table->dropIndexIfExists('review_logs_pengajuan_id_index');
            $table->dropIndexIfExists('review_logs_reviewer_id_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndexIfExists('users_status_index');
            $table->dropIndexIfExists('users_role_index');
        });
    }
};
