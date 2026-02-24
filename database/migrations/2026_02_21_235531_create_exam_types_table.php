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
        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);

            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('pin_background_image')->nullable();
            $table->string('result_page_url')->nullable();

            $table->longText('about_content')->nullable();
            $table->longText('how_to_buy_content')->nullable();
            $table->longText('how_to_check_content')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('stock_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_types');
    }
};
