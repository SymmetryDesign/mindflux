<?php

use App\Models\Column;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $columns = Column::all();

        $columns->each(function ($column) {
            $users = $column->project->teamMembers->pluck('id')->toArray();
            $index = 0;

            factory(Task::class, 4)->state(Arr::random(['completed', 'incompleted']))->make()->each(function ($task) use ($column, $users, &$index) {
                $task->column_id = $column->id;
                $task->user_id = Arr::random($users);
                $task->index = $index;
                $task->save();
                $index++;
            });
        });
    }
}
