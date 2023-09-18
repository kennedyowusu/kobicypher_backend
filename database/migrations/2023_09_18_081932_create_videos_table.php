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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('link', 255);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id')->index();
            $table->softDeletes();

            $table->timestamps();

            //  Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unique(['id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
