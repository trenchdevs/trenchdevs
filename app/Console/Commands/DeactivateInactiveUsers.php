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
    protected $signature = 'deactivate:inactiveusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate users who are inactive';

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
        User::deactivateInactiveUsers(1);
    }
}
