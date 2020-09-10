<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TODO: need add more statistics data such as visits
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');

            # belongsTo: Category
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('thumbnail')->nullable();
            $table->string('title')->unique();        # translatable
            $table->string('slug')->unique();
            $table->string('sub_title')->nullable();  # translatable

            $table->enum('is_top', ['0', '1']);
            $table->enum('limit', ['0', '1']);

            $table->enum('is_reproduced', ['0', '1']);
            $table->string('source')->nullable();
            $table->text('source_url')->nullable();

            $table->string('editor')->nullable();
            $table->text('intro')->nullable();        # translatable
            $table->text('details');                  # translatable
            $table->string('post_type');

            $table->enum('is_published', ['0', '1']);

            # Many to Many: [Author, Tag]
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
