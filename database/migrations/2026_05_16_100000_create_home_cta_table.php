<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_cta', function (Blueprint $table) {
            $table->id();
            $table->string('heading_before');
            $table->string('heading_highlight');
            $table->string('heading_after');
            $table->text('body');
            $table->string('button_label');
            $table->string('button_href');
            $table->string('bg_image')->nullable();
            $table->string('cartoon_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_cta');
    }
};
