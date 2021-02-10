<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('content');
            $table->integer('index')->nullable()->unsigned();
            $table->date('due_date')->nullable();
            $table->integer('priority')->unsigned()->nullable();
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            $table->bigInteger('column_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('task_id')->unsigned()->nullable();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('column_id')->references('id')->on('columns')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_column_id_foreign');
            $table->dropForeign('tasks_column_id_foreign');
            $table->dropForeign('tasks_task_id_foreign');
        });

        Schema::dropIfExists('tasks');
    }
}
