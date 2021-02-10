<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipboard:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Shipboard system installation process';

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
        $this->verifyPHPVersion();
        $this->verifyExtensions();
        $this->verifyWritePermissions();
        $this->generateAppKey();
        $this->setupDatabase();
        $this->configureSystemSettings();
        $this->createAdminUser();

        $this->info('Finished installing Shipboard successfully. For any support required, please email us on support@phpify.dev');
    }

    /**
     * Verify that the command is running on the required PHP version.
     *
     * @return bool
     */
    protected function verifyPHPVersion()
    {
        $this->line('Verifying PHP version..');

        if (version_compare(PHP_VERSION, '7.2.5', '>=')) {
            $this->info('PHP Version is verified successfully.');

            return true;
        }

        $this->info(
            sprintf('You are trying to run the installer using an old PHP version (%s). Please use the required PHP version or newer to continue.', PHP_VERSION)
        );

        exit;
    }

    /**
     * Verify required PHP extensions.
     *
     * @return void
     */
    protected function verifyExtensions()
    {
        $this->line('Verifying PHP extensions..');

        $extensions = [
            'pdo_mysql', 'openssl', 'mbstring', 'tokenizer', 'curl',
        ];

        foreach ($extensions as $extension) {
            if (!extension_loaded($extension)) {
                $this->info(
                    sprintf('PHP extension %s is not enabled.', $extension)
                );

                exit;
            }
        }

        $this->info('PHP extensions verified successfully.');
    }

    /**
     * Verify if specified folders are writable.
     *
     * @return void
     */
    protected function verifyWritePermissions()
    {
        $this->line('Verifying folder write permissions..');

        $paths = [
            config_path('/'), storage_path('/')
        ];

        foreach ($paths as $path) {
            if (!is_writable($path)) {
                $this->info(
                    sprintf('The following path is not writable (%s). Please change folder permissions.', $path)
                );

                exit;
            }
        }

        $this->info('Folder permissions are verified successfully.');
    }

    /**
     * Generate private application key.
     *
     * @return void
     */
    protected function generateAppKey()
    {
        $this->line('Generating application key..');

        $this->call('key:generate', ['--force' => true]);

        $this->info('Application key generated successfully.');
    }

    /**
     * Setup the database.
     *
     * @return void
     */
    protected function setupDatabase()
    {
        $this->line('Installing the database...');

        $this->call('migrate:fresh', ['--force' => true]);

        $this->info('Database installed successfully.');
    }

    /**
     * Configure system settings.
     *
     * @return void
     */
    protected function configureSystemSettings()
    {
        $this->line('Configuring system settings...');

        settings([
            'logo.light'          => '/imgs/logo_light.png',
            'logo.dark'           => '/imgs/logo_dark.png',
            'favicon'             => '/imgs/favicon.ico',
            'hero.image'          => '/svg/devices.svg',
            'hero.heading'        => 'Team Collaboration Platform',
            'hero.subheading'     => 'A better way to collaborate with your team to get things done faster. Sign up to get started',
            'pricing.heading'     => 'The Right Price for You',
            'pricing.subheading'  => 'Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.',
            'features.heading'    => 'A better way to collaborate',
            'features.subheading' => 'Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.',
            'webhook.secret'      => Str::uuid(),
        ]);

        $this->info('System settings configured successfully.');
    }

    /**
     * Create admin user.
     *
     * @return void
     */
    protected function createAdminUser()
    {
        $this->line('Creating admin user..');

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('secret'),
            'role'     => User::ROLE_ADMIN,
        ]);

        $this->info('Admin user created successfully.');

        $this->line('---------------------------------------------------------------------');
        $this->line('Admin User Credentials');
        $this->line('---------------------------------------------------------------------');
        $this->line('Email: admin@example.com');
        $this->line('Password: secret');
        $this->line('---------------------------------------------------------------------');
    }
}
