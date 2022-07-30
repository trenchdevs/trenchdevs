<?php

namespace App\Modules\Aws\Console\Commands;

use App\Modules\Aws\Services\S3ImageRemoverService;
use Illuminate\Console\Command;

class S3ImageRemoverCommand extends Command
{

    protected $signature = 's3:purge_images';

    protected $description = 'Removes images marked for deletion on s3';

    public function handle(S3ImageRemoverService $s3ImageRemover)
    {
        $s3ImageRemover->deleteImagesMarkedForDeletion();
    }

}
