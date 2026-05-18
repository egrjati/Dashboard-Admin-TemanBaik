<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_page_heroes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_card_id')->constrained('program_cards')->cascadeOnDelete();
            $table->string('bg_image')->nullable();
            $table->string('heading')->default('');
            $table->string('heading_highlight')->default('');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('program_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_card_id')->constrained('program_cards')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('program_page_ctas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_card_id')->constrained('program_cards')->cascadeOnDelete();
            $table->string('bg_image')->nullable();
            $table->string('heading')->default('');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_page_ctas');
        Schema::dropIfExists('program_items');
        Schema::dropIfExists('program_page_heroes');
    }
};
