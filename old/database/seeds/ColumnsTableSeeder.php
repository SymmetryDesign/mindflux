<?php

use App\Models\Column;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ColumnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::all()->pluck('id');

        $projects->each(function ($project) {
            $index = 0;

            factory(Column::class, 3)->make()->each(function ($column) use ($project, &$index) {
                $column->project_id = $project;
                $column->index = $index;
                $column->save();
                $index++;
            });
        });
    }
}
