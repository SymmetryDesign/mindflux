<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first = User::find(2);
        $second = User::find(3);

        $first->tenant->projects->take(5)->each(function ($project) use ($first) {
            DB::table('favorite_project_user')
                ->insert([
                    ['project_id' => $project->id, 'user_id' => $first->id],
                ]);
        });

        $second->tenant->projects->take(5)->each(function ($project) use ($second) {
            DB::table('favorite_project_user')
                ->insert([
                    ['project_id' => $project->id, 'user_id' => $second->id],
                ]);
        });
    }
}
