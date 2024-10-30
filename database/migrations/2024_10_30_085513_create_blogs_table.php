<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail_url');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('description');
            $table->longText('content');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Thêm trường author_id
            $table->string('tags')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('feature')->default(0); // trạng thái bài viết, ví dụ: kích hoạt hay không
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
