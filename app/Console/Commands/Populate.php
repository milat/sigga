<?php

namespace App\Console\Commands;

use App\Services\PopulateService;
use Illuminate\Console\Command;

class Populate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:populate {office_id} {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to populate database with fake data';

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
        PopulateService::run(
            $this->argument('office_id'),
            $this->argument('user_id')
        );
    }
}
