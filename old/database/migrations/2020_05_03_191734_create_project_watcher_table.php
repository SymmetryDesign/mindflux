<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectWatcherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_watcher', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('project_id')->unsigned();
        });

        Schema::table('project_watcher', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_watcher', function (Blueprint $table) {
            $table->dropForeign('project_watcher_user_id_foreign');
            $table->dropForeign('project_watcher_project_id_foreign');
        });

        Schema::dropIfExists('project_watcher');
    }
}
