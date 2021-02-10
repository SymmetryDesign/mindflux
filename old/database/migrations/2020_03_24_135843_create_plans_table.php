<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->float('price')->unsigned();
            $table->integer('max_projects')->unsigned()->nullable();
            $table->integer('max_users_per_project')->unsigned()->nullable();
            $table->float('disk_space')->unsigned()->nullable();
            $table->integer('status')->unsigned();
            $table->integer('trial_days')->nullable();
            $table->boolean('is_default');
            $table->boolean('is_featured');
            $table->timestamps();
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }

    /**
     * Seed the database table with data.
     *
     * @return void
     */
    protected function seed()
    {
        Plan::create([
            'name'                  => 'Free',
            'description'           => 'Free limited features for individuals',
            'price'                 => 0,
            'is_default'            => true,
            'is_featured'           => false,
            'status'                => Plan::STATUS_ACTIVE,
            'max_projects'          => 50,
            'max_users_per_project' => 20,
            'disk_space'            => 1000,
        ]);

        Plan::create([
            'name'                  => 'Basic',
            'description'           => 'Basic features for individuals and small teams',
            'price'                 => 5,
            'is_default'            => false,
            'is_featured'           => true,
            'status'                => Plan::STATUS_ACTIVE,
            'max_projects'          => 200,
            'max_users_per_project' => 50,
            'disk_space'            => 5000,
        ]);

        Plan::create([
            'name'                  => 'Premium',
            'description'           => 'Premium features for individuals and teams',
            'price'                 => 10,
            'is_default'            => false,
            'is_featured'           => false,
            'status'                => Plan::STATUS_ACTIVE,
            'max_projects'          => null,
            'max_users_per_project' => null,
            'disk_space'            => null,
        ]);
    }
}
