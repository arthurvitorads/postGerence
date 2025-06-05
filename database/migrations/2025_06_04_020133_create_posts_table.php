<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relacionamento com users
            $table->string('title');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes(); // para soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
