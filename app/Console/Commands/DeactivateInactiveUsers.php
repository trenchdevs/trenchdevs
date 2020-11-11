<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class DeactivateInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivate:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivates inactive users.';

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
        User::deactivateUsers(20);
    }
}
