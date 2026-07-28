<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('likes_count')->default(0);
            $table->timestamps();

            $table->index('author_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};