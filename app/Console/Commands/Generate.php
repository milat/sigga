<?php

namespace App\Console\Commands;

use App\Services\GenerateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create a fake office and its dependencies. See config/generate.php';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Starting');
        DB::beginTransaction();

        try {
            /**
             *  Creating Office
             */
            $office = GenerateService::createOffice();

            if (!$office) {
                throw new \Exception('office');
            }

            $this->info('Office created successfully.');

            /**
             *  Creating Roles
             */
            $roles = GenerateService::createRoles($office);

            if (!$roles or empty($roles)) {
                throw new \Exception('roles');
            }

            $this->info('Roles created successfully.');

            /**
             *  Creating Permissions
             */
            if (!GenerateService::createRolePermissions($roles)) {
                throw new \Exception('permissions');
            }

            $this->info('Permissions created successfully.');

            /**
             *  Creating Users
             */
            if (!GenerateService::createUsers($office, $roles)) {
                throw new \Exception('users');
            }

            $this->info('Users created successfully.');

            /**
             *  Creating Request Categories
             */
            if (!GenerateService::createRequestCategories($office)) {
                throw new \Exception('request categories');
            }

            $this->info('Request Categories created successfully.');

        } catch (\Exception $e) {
            $this->error('Couldnt create '.$e->getMessage());
            DB::rollBack();
            exit;
        }

        $this->info('Finishing');
        DB::commit();
    }
}
