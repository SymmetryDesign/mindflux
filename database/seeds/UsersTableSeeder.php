<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->admins();
        $this->tenantOwners();
        $this->tenantUsers();

        User::all()->each(function ($user) {
            $this->setFakeUserAvatar($user);
        });
    }

    /**
     * Seed the database table with admins.
     *
     * @return void
     */
    protected function admins()
    {
        factory(User::class)->state('admin')->create([
            'email' => 'admin@example.com',
        ]);
    }

    /**
     * Seed the database table with tenant owners.
     *
     * @return void
     */
    protected function tenantOwners()
    {
        factory(User::class)->state('tenant_owner')->create([
            'email'     => 'first@example.com',
            'tenant_id' => 1,
        ]);

        factory(User::class)->state('tenant_owner')->create([
            'email'     => 'second@example.com',
            'tenant_id' => 2,
        ]);
    }

    /**
     * Seed the database table with tenant users.
     *
     * @return void
     */
    protected function tenantUsers()
    {
        factory(User::class, 5)->state('tenant_user')->create([
            'tenant_id' => 1,
        ]);

        factory(User::class, 5)->state('tenant_user')->create([
            'tenant_id' => 2,
        ]);
    }

    /**
     * Set a fake user avatar.
     *
     * @param $user
     * @throws Exception
     */
    protected function setFakeUserAvatar($user)
    {
        $media = MediaUploader::fromSource('https://i.pravatar.cc/150?img=' . $user->id)
            ->toDestination('public', 'avatars')
            ->onDuplicateIncrement()
            ->useHashForFilename()
            ->beforeSave(function ($media) {
                $media->uuid = Str::uuid();
            })
            ->upload();

        $user->attachMedia($media, 'avatars');
    }
}
