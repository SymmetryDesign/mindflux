<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteProjectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_project_user', function (Blueprint $table) {
            $table->bigInteger('project_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
        });

        Schema::table('favorite_project_user', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorite_project_user', function (Blueprint $table) {
            $table->dropForeign('favorite_project_user_project_id');
            $table->dropForeign('favorite_project_user_user_id');
        });

        Schema::dropIfExists('favorite_project_user');
    }
}
