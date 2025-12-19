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
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('checklist_id');
            $table->string('label');
            $table->enum('type', ['boolean', 'text', 'number', 'select']);
            $table->json('options')->nullable(); // For 'select' type, store options
            $table->integer('order')->default(0);
            $table->foreign('checklist_id')
                ->references('id')
                ->on('checklist')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};
