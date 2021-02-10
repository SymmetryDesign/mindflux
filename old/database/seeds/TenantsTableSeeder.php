<?php

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['cus_H2weNsl1qkJzwy', 'cus_H2wetNx0RBIj1u'])->each(function ($customerId) {
            factory(Tenant::class)->create([
                'customer_id' => $customerId,
            ]);
        });
    }
}
