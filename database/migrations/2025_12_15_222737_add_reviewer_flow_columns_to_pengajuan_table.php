<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->unsignedTinyInteger('current_reviewer_level')
                  ->nullable()
                  ->after('status');

            $table->timestamp('review_deadline')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn([
                'current_reviewer_level',
                'review_deadline',
                'approved_at',
                'rejected_at'
            ]);
        });
    }
};
