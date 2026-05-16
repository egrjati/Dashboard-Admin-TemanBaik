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
        Schema::table('about', function (Blueprint $table) {
            $table->string('story_title')->nullable()->after('description');
            $table->text('story_description')->nullable()->after('story_title');
            $table->string('story_image_1')->nullable()->after('story_description');
            $table->string('story_image_2')->nullable()->after('story_image_1');
            $table->string('story_image_3')->nullable()->after('story_image_2');
        });
    }

    public function down(): void
    {
        Schema::table('about', function (Blueprint $table) {
            $table->dropColumn(['story_title', 'story_description', 'story_image_1', 'story_image_2', 'story_image_3']);
        });
    }
};
