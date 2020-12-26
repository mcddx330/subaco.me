<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiaryArticleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_article', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->index();
            $table->string('current_status')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->string('type')->index();
            $table->string('slug')->index();
            $table->string('title')->index();
            $table->longText('body')->nullable();
            $table->text('thumbnail_filename')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diary_article');
    }
}
