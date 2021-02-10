<?php

use App\Models\Project;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = Tenant::all();

        $tenants->each(function ($tenant) {
            for ($i = 0; $i <= 12; $i++) {
                $this->createProject(
                    $tenant,
                    Arr::random(['ongoing', 'overdue', 'completed'])
                );
            }
        });
    }

    /**
     * Create project for the given tenant.
     *
     * @param App\Models\Tenant $tenant
     * @param string $status
     */
    protected function createProject($tenant, $status)
    {
        $project = factory(Project::class)->state($status)->create([
            'tenant_id' => $tenant->id,
            'user_id'   => Arr::random($tenant->users->pluck('id')->toArray()),
        ]);

        $project->teamMembers()->sync(
            $tenant->users->pluck('id')->where('uuid', '!==', $project->user_id)->all()
        );
    }
}
