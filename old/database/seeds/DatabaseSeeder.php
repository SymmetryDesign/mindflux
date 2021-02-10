<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FeaturesTableSeeder::class);
        $this->call(TenantsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(ColumnsTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(FavoriteProjectsTableSeeder::class);
    }
}
