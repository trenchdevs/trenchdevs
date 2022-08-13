<?php

namespace App\Console\Commands;

use App\Modules\Projects\Models\Project;
use App\Modules\Sites\Enums\SiteIdentifier;
use App\Modules\Sites\Models\Site;
use App\Modules\Users\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class UtilitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utilities:execute {fn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute generic utilities';

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
    public function handle(): int
    {
        $fn = $this->argument('fn');
        // in the future this can be a Factory instead
        switch ($fn) {
            case 'initialize_project_data':
                $this->initializeProjectData();
                break;
            case 'test:dispatch':
                dispatch(function(){
                   echo "hello world from dispatch" . PHP_EOL;
                });
                break;
            default:
                $this->alert("Function not found \"$fn\"");
        }

        return 0;
    }

    private function initializeProjectData()
    {

        $projectsArr = [
            [
                'title' => 'TrenchDevsAdmin',
                'repository_url' => 'https://github.com/trenchdevs/trenchdevs',
                'image_url' => '/logo/v1/logo.png',
            ],
            [
                'title' => 'SAMSCIS Queueing System',
                'repository_url' => '',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/samscis.jpg'
            ],
            [
                'title' => 'My Transient House (Multi Tenant App, SaaS)',
                'repository_url' => 'https://github.com/christopheredrian/mytransienthouse',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/mytransienthouse.jpg',
            ],
            [
                'title' => 'Project Lengua - API',
                'repository_url' => 'http://project-lengua.herokuapp.com/',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/project-lengua.png',
            ],
            [
                'title' => 'InfoSentiA - Research Division, Baguio City',
                'repository_url' => 'https://github.com/christopheredrian/research-division',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/infosentia.png',
            ],
            [
                'title' => 'B2B Scheduler - Haranah-Phitex, Philippines',
                'repository_url' => 'https://github.com/christopheredrian/haranah-phitex',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/haranah.jpg',
            ],
            [
                'title' => 'Procurement System - Bureau of Fire Protection, Baguio City ',
                'repository_url' => 'http://bfp-test.herokuapp.com',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/bfp.png',
            ],
            [
                'title' => 'Alumni Tracker - San Jose Seminary, Quezon City',
                'repository_url' => 'https://github.com/christopheredrian/sjp-v3',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/sjp.png',
            ],
        ];

        $projectsArr = array_reverse($projectsArr);

        try {

            DB::beginTransaction();

            foreach ($projectsArr as $projectData) {

                Site::setInstance(Site::fromIdentifier(SiteIdentifier::TRENCHDEVS));
                $projectData['is_personal'] = 0;
                $projectData['user_id'] = User::query()->find(1)->id;
                $projectData['url'] = $projectData['repository_url'] ?? '';

                $project = new Project();
                $project->fill($projectData);
                $project->saveOrFail();
                $this->line("Successfully saved project: {$project->title}");
            }

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            $this->line($exception->getMessage());
        }

    }
}
