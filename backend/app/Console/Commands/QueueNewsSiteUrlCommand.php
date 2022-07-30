<?php

namespace App\Console\Commands;

use App\Modules\News\Repositories\NewsRepositoryFactory;
use Exception;
use Illuminate\Console\Command;
use InvalidArgumentException;

class QueueNewsSiteUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:queue {--u|url= :Url to queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue a site URL - add this to SQS';

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

        try {

            $url = $this->option('url');

            if (empty($url) || !is_valid_url($url)) {
                throw new InvalidArgumentException("Invalid URL given");
            }

            $newsRepository = NewsRepositoryFactory::getInstance();

            $message = "Queueing News URL from trenchdevs command line";

            $newsRepository->queue($message, [
                'url' => $url,
                'now' => mysql_now(),
                'source' => 'trenchdevs::command:news:queue'
            ]);

        } catch (Exception $exception) {
            $this->line($exception->getMessage(), 'fg=red');
        }

        return 1;
    }
}
