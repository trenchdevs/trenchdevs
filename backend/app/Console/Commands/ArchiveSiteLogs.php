<?php

namespace App\Console\Commands;

use App\Domains\Sites\Services\SiteAccessLogsArchiverService;
use Exception;
use Illuminate\Console\Command;

class ArchiveSiteLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:site_access_logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive Site Access logs to s3';

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
     * @param SiteAccessLogsArchiverService $archiver
     * @return void
     */
    public function handle(SiteAccessLogsArchiverService $archiver)
    {

        try {

            $this->line(sprintf("Processing Start Time: %s", date('Y-m-d H:i:s')));
            $archiver->process();
            $this->line(sprintf("Processing End Time: %s", date('Y-m-d H:i:s')));

        }catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
