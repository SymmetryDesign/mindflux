<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipboard:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start setting up Shipboard demo environment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->purgePublicStorageFiles();
        $this->purgePrivateStorageFiles();
        $this->refreshDatabase();
        $this->resetSettings();

        $this->info('Demo refresh is completed successfully.');
    }

    /**
     * Remove specified public storage files.
     *
     * @return void
     */
    protected function purgePublicStorageFiles()
    {
        $this->line('Removing public storage files..');

        if (File::exists(public_path('avatars'))) {
            File::delete(
                collect(File::allFiles(public_path('avatars')))->toArray()
            );
        }

        $this->info('Removed public storage files.');
    }

    /**
     * Remove specified private storage files.
     *
     * @return void
     */
    protected function purgePrivateStorageFiles()
    {
        $this->line('Removing private storage files..');

        if (File::exists(storage_path('app/tasks'))) {
            File::delete(
                collect(File::allFiles(storage_path('app/tasks')))->toArray()
            );
        }

        $this->info('Removed private storage files.');
    }

    /**
     * Refresh the database with new data.
     *
     * @return void
     */
    protected function refreshDatabase()
    {
        $this->call('migrate:fresh', ['--force' => true]);
        $this->call('db:seed', ['--force' => true]);
    }

    /**
     * Reset system settings to the original state.
     *
     * @return void
     */
    protected function resetSettings()
    {
        $this->line('Configuring system settings..');

        settings([
            'logo.light'                     => '/imgs/logo_light.png',
            'logo.dark'                      => '/imgs/logo_dark.png',
            'favicon'                        => '/imgs/favicon.ico',
            'hero.image'                     => '/svg/devices.svg',
            'hero.heading'                   => 'Team Collaboration Platform',
            'hero.subheading'                => 'A better way to collaborate with your team to get things done faster. Sign up to get started',
            'pricing.heading'                => 'The Right Price for You',
            'pricing.subheading'             => 'Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.',
            'features.heading'               => 'A better way to collaborate',
            'features.subheading'            => 'Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.',
            'webhook.secret'                 => '30a9edf0-3af1-41eb-a24d-9e35bd2fb717',
            'terms_and_conditions.published' => true,
            'terms_and_conditions.content'   => faker()->paragraphs(20, true),
            'privacy_policy.published'       => true,
            'privacy_policy.content'         => faker()->paragraphs(20, true),
        ]);

        $this->info('Configured system settings');
    }
}
