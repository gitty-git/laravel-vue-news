<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimaryCategoryPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_category_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title', 100);
            $table->string('brief', 200);
            $table->string('image');
            $table->text('body');
            $table->string('slug')->unique();
            $table->enum('is_published', [1, 0])->default(1);

            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('primary_category_posts');
    }
}
