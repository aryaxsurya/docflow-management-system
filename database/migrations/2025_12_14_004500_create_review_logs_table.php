<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('review_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_id')
                  ->constrained('pengajuan')
                  ->cascadeOnDelete();

            $table->foreignId('reviewer_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->tinyInteger('reviewer_level')
                  ->comment('Level reviewer: 1,2,3');

            $table->enum('action', [
                'approve',
                'request_changes',
                'reject'
            ]);

            $table->text('note')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_logs');
    }
};
