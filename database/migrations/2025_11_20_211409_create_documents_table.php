<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('type')->nullable();
        $table->string('unit')->nullable();
        $table->text('description')->nullable();
        $table->date('effective_date')->nullable();
        $table->string('status')->default('draft'); // draft, review1, approved, rejected
        $table->string('attachment_path')->nullable();
        $table->unsignedBigInteger('creator_id');
        $table->timestamps();

        $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
