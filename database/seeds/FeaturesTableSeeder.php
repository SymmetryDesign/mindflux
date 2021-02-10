<?php

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->features();
    }

    /**
     * Seed the database with features.
     *
     * @return void
     */
    protected function features()
    {
        Feature::create([
            'title'       => 'Snappy UI',
            'description' => 'Navigate quickly between your projects',
        ]);

        Feature::create([
            'title'       => 'Projects',
            'description' => 'Create a dedicated workspace for your projects and invite your team members to collaborate',
        ]);

        Feature::create([
            'title'       => 'Kanban',
            'description' => 'Manage your tasks as Kanban cards by dragging and dropping them into different project stages',
        ]);

        Feature::create([
            'title'       => 'My Tasks',
            'description' => 'Easily manage tasks assigned to you in a dedicated page',
        ]);

        Feature::create([
            'title'       => 'Calendar',
            'description' => 'Get an eagle-view of your tasks deadline using a dedicated calendar view',
        ]);

        Feature::create([
            'title'       => 'Dashboard',
            'description' => 'Get a quick insights about your organization projects and your producutivity',
        ]);
    }
}
