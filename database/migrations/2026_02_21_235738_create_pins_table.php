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
        Schema::create('pins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->constrained()->cascadeOnDelete();
            $table->string('pin')->unique();
            $table->string('serial_number')->unique();

            $table->enum('status', ['available', 'sold'])->default('available');
            $table->foreignId('sold_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sold_at')->nullable();

            $table->timestamps();
            $table->index(['exam_type_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pins');
    }
};
