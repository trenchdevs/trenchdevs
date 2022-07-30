<?php

namespace App\Console\Commands;

use App\Modules\Users\Models\User;
use Illuminate\Console\Command;

class SendDeactivationNoticeToUsers  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:deactivation-notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send deactivation notice email to inactive users';

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
        User::sendDeactivationNotice(1, 20);
    }
}
